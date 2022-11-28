<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Proceso;
use App\Models\Subproceso;
use App\Models\FuenteEmision;
use Illuminate\Support\Facades\DB;

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
        foreach ($procesos["procesos"] as $p) {
            //Crear proceso
            $proceso = new Proceso;
            //por validar el id de la empresa, sede e informacion si se envia desde el vue
            $proceso->informacion_empresa_id = 1;
            $proceso->empresa_id = 1;
            $proceso->sede_id = 1;
            $proceso->nombre = $p['nombre'];
            $proceso->save();
            foreach ($p["subprocesos"] as $sp) {
                //Crear subproceso
                $subproceso = new Subproceso;
                $subproceso->nombre = $sp['nombre'];
                $subproceso->descripcion = $sp['descripcion'];
                $subproceso->proceso_id = $proceso->id;
                //por validar el id de la empresa y sede se envia desde el vue
                $subproceso->empresa_id = 1;
                $subproceso->sede_id = 1;
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

                                    $modelo = '';
                                    if (str_contains($ksf, 'combustibles')) {
                                        $modelo = 'combustibles';
                                    } else if ($ksf == 'embalses' || $ksf == 'minerias' || $ksf == 'industriales' || $ksf == 'residuos_organizacionales') {
                                        $modelo = 'emisiones';
                                    } else if ($ksf == 'cales') {
                                        $modelo = 'fertilizantes';
                                    } else if ($ksf == 'residuos_agropecuarios') {
                                        $modelo = 'estiercoles';
                                    } else {
                                        $modelo = $ksf;
                                    }

                                    $fuente_emision->modelo = $modelo;
                                    $fuente_emision->modelo_id = $v;
                                    $fuente_emision->subproceso_id = $subproceso->id;
                                    //por validar el id de la empresa, sede e informacion se envia desde el vue
                                    $fuente_emision->informacion_empresa_id = 1;
                                    $fuente_emision->empresa_id = 1;
                                    $fuente_emision->sede_id = 1;
                                    $fuente_emision->save();
                                }
                            }
                        }
                    }
                }
            }
        }
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
