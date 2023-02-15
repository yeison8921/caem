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

    public function guardarProcesos($request)
    {

        if ($request->actualizar) {

            $array_procesos = [];
            $array_subprocesos = [];
            $array_nuevos = [];

            foreach ($request['procesos'] as $p) {
                if ($p['id'] != '') {
                    array_push($array_procesos, $p['id']);
                }
                foreach ($p['subprocesos'] as $kp => $sp) {
                    if ($sp['id'] != '') {
                        array_push($array_subprocesos, $sp['id']);
                    }
                    foreach ($sp as $kf => $fuente) {
                        if ($kf != 'id' && $kf != 'nombre' && $kf != 'descripcion') {
                            $tipo = $kf;
                            $array_nuevos[$tipo][$sp['id']] = [];
                            foreach ($fuente as $ksf => $sf) {
                                $array_nuevos[$tipo][$sp['id']][$ksf] = [];
                                foreach ($sf as $v) {
                                    array_push($array_nuevos[$tipo][$sp['id']][$ksf], $v);
                                }
                            }
                        }
                    }
                }
            }

            foreach ($array_nuevos as $key => $value) {
                foreach ($value as $sk => $sv) {
                    foreach ($sv as $k => $v) {
                        FuenteEmision::where([
                            ['subproceso_id', $sk],
                            ['tipo', $key],
                            ['fuente_emision', $k],
                        ])->whereNotIn('fuentetable_id', $v)->delete();
                    }
                }
            }

            FuenteEmision::whereNotIn('subproceso_id', $array_subprocesos)->delete();
            Subproceso::whereNotIn('id', $array_subprocesos)->delete();
            Proceso::whereNotIn('id', $array_procesos)->delete();
        }

        foreach ($request['procesos'] as $p) {
            if ($p['id'] == '') {
                $proceso = new Proceso;
                $proceso->informacion_empresa_id = $request->informacion_empresa_id;
                $proceso->empresa_id = $request->empresa_id;
                $proceso->sede_id =  $request->sede_id;
                $proceso->nombre = $p['nombre'];
                $proceso->save();
                $proceso_id = $proceso->id;
            } else {
                $proceso_id = $p['id'];
            }
            foreach ($p['subprocesos'] as $sp) {
                if ($sp['id'] == '') {
                    $subproceso = new Subproceso;
                    $subproceso->nombre = $sp['nombre'];
                    $subproceso->descripcion = $sp['descripcion'];
                    $subproceso->proceso_id = $proceso_id;
                    $subproceso->empresa_id = $request->empresa_id;
                    $subproceso->sede_id = $request->sede_id;
                    $subproceso->save();
                    $subproceso_id = $subproceso->id;
                } else {
                    $subproceso_id = $sp['id'];
                }
                foreach ($sp as $kf => $fuente) {
                    if ($kf != 'id' && $kf != 'nombre' && $kf != 'descripcion') {
                        foreach ($fuente as $ksf => $sf) {
                            foreach ($sf as $v) {
                                $fuente_existe = FuenteEmision::where([
                                    ['tipo', $kf],
                                    ['fuente_emision', $ksf],
                                    ['fuentetable_id', $v],
                                    ['subproceso_id', $sp['id']],
                                ])->first();

                                if (is_null($fuente_existe)) {
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
                                    $fuente_emision->subproceso_id = $subproceso_id;
                                    $fuente_emision->informacion_empresa_id = $request->informacion_empresa_id;
                                    $fuente_emision->empresa_id = $request->empresa_id;
                                    $fuente_emision->sede_id = $request->sede_id;
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
                ['sede_id', $request->sede_id],
                ['informacion_empresa_id', $request->informacion_empresa_id],
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
