<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Emision;
use App\Models\FuenteEmision;
use App\Models\InformacionEmpresa;
use App\Models\Proceso;
use App\Models\Subproceso;
use Illuminate\Support\Facades\DB;
use stdClass;

/**
 * Class ProcesoRepository.
 */
class ProcesoRepository extends BaseRepository
{
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function model()
    {
        return Proceso::class;
    }

    public function guardarProcesos($procesos)
    {
        $usuarioEmpresaId = auth('api')->user()->empresa_id;
        $usuarioSedeId = auth('api')->user()->sede_id;

        //verificar si se borro algun id
        foreach ($procesos['procesos'] as $p) {
            //Crear proceso
            $proceso = new Proceso;
            $informacionEmpresa = InformacionEmpresa::where('empresa_id', $usuarioEmpresaId)->where('sede_id', $usuarioSedeId)->first();
            $proceso->informacion_empresa_id = $informacionEmpresa->id;
            $proceso->empresa_id = $usuarioEmpresaId;
            $proceso->sede_id = $usuarioSedeId;
            $proceso->nombre = $p['nombre'];
            $proceso->save();
            foreach ($p['subprocesos'] as $sp) {

                //Crear subproceso
                $subproceso = new Subproceso;
                $subproceso->nombre = $sp['nombre'];
                $subproceso->descripcion = $sp['descripcion'];
                $subproceso->proceso_id = $proceso->id;
                $subproceso->empresa_id = $usuarioEmpresaId;
                $subproceso->sede_id = $usuarioSedeId;
                $subproceso->save();

                foreach ($sp as $kf => $fuente) {
                    if ($kf != 'nombre' && $kf != 'descripcion') {
                        foreach ($fuente as $ksf => $sf) {
                            foreach ($sf as $v) {
                                if ($v != -1) {
                                    //Crear fuente emision
                                    $fuente_emision = new FuenteEmision;
                                    $fuente_emision->tipo = $kf;
                                    $fuente_emision->fuente_emision = $ksf;

                                    $modelo = 'App\Models\\';
                                    if (str_contains($ksf, 'Combustible')) {
                                        $modelo .= 'Combustible';
                                    } elseif ($ksf == 'Embalse' || $ksf == 'Mineria' || $ksf == 'Industrial' || $ksf == 'Residuo_organizacional') {
                                        $modelo .= 'Emision';
                                    } elseif ($ksf == 'Cal') {
                                        $modelo .= 'Fertilizante';
                                    } elseif ($ksf == 'Residuo_agropecuario') {
                                        $modelo .= 'Estiercol';
                                    } else {
                                        $modelo .= $ksf;
                                    }

                                    $fuente_emision->fuentetable_type = $modelo;
                                    $fuente_emision->fuentetable_id = $v;
                                    $fuente_emision->subproceso_id = $subproceso->id;
                                    $fuente_emision->informacion_empresa_id = $informacionEmpresa->id;
                                    $fuente_emision->empresa_id = $usuarioEmpresaId;
                                    $fuente_emision->sede_id = $usuarioSedeId;
                                    $fuente_emision->save();
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function recargarProcesos($request)
    {
        $procesos = Proceso::with('subprocesos', 'subprocesos.fuentesEmision')->where(
            [
                ['empresa_id', $request->empresa_id],
                ['sede_id', $request->sede_id]
            ]
        )->get();

        $array_procesos = [];
        foreach ($procesos as $p) {
            //json proceso
            $jp = new stdClass();
            $jp->id = $p->id;
            $jp->nombre = $p->nombre;
            $jp->subprocesos = [];
            array_push($array_procesos, $jp);
            foreach ($p->subprocesos as $sp) {
                $jsp = new stdClass();
                $jsp->id = $sp->id;
                $jsp->nombre = $sp->nombre;
                $jsp->descripcion = $sp->descripcion;
                array_push($jp->subprocesos, $jsp);

                //json fuentes fijas
                $jff = new stdClass();
                $jff->Combustible_solido = [];
                $jff->Combustible_liquido = [];
                $jff->Combustible_gaseoso = [];
                $jff->Refrigerante = [];
                $jff->Extintor = [];
                $jff->Lubricante = [];
                $jff->Fuga = [];
                $jff->Aislamiento = [];

                //json fuentes móviles
                $jfm = new stdClass();
                $jfm->Combustible_liquido = [];
                $jfm->Combustible_gaseoso = [];
                $jfm->Refrigerante = [];
                $jfm->Extintor = [];
                $jfm->Lubricante = [];

                //json emisiones
                $je = new stdClass();
                $je->Embalse = [];
                $je->Mineria = [];
                $je->Industrial = [];
                $je->Fermentacion = [];
                $je->Estiercol = [];
                $je->Residuo_organizacional = [];
                $je->Residuo_agropecuario = [];
                $je->Fertilizante = [];
                $je->Cal = [];

                foreach ($sp->fuentesEmision as $f) {
                    $fuente = $f->fuente_emision;
                    if ($f->tipo == 'fuentes_fijas') {
                        array_push($jff->$fuente, $f->fuentetable_id);
                    }
                    if ($f->tipo == 'fuentes_moviles') {
                        array_push($jfm->$fuente, $f->fuentetable_id);
                    }
                    if ($f->tipo == 'emisiones') {
                        array_push($je->$fuente, $f->fuentetable_id);
                    }
                }
                $jsp->fuentes_fijas = $jff;
                $jsp->fuentes_moviles = $jfm;
                $jsp->emisiones = $je;
            }
        }

        return $array_procesos;
    }

    /**
     * @param array $data
     *
     * @return Proceso
     * @throws \Exception
     * @throws \Throwable
     */
    // public function create(array $data): Proceso
    // {
    //     return DB::transaction(function () use ($data) {
    //         $proceso = Proceso::create($data);
    //         if ($proceso) {
    //             return $proceso;
    //         }

    //         throw new GeneralException(__('backend_procesos.exceptions.create_error'));
    //     });
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    // public function update($request, $id_proceso)
    // {
    //     $proceso = Proceso::find($id_proceso);
    //     $proceso->update($request->all());
    //     return $proceso;
    // }
}
