<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\FuenteEmision;
use Illuminate\Support\Facades\DB;

/**
 * Class FuenteEmisionRepository.
 */
class FuenteEmisionRepository extends BaseRepository
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
        return FuenteEmision::class;
    }

    /**
     * @param array $data
     *
     * @return FuenteEmision
     * @throws \Exception
     * @throws \Throwable
     */
    // public function create(array $data): FuenteEmision
    // {
    //     return DB::transaction(function () use ($data) {
    //         $fuente_emision = FuenteEmision::create($data);
    //         if ($fuente_emision) {
    //             return $fuente_emision;
    //         }

    //         throw new GeneralException(__('backend_Fuentes_emision.exceptions.create_error'));
    //     });
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id_fuente_emision)
    {
        $fuente_emision = FuenteEmision::find($id_fuente_emision);
        $fuente_emision->update($request->all());
        return $fuente_emision;
    }

    public function guardarEmisionesIndirectas($emisiones)
    {
        foreach ($emisiones["emisiones"] as $ke => $e) {
            foreach ($e as $ksf => $sf) {
                $modelo = 'App\Models\\';

                if (str_contains($ksf, 'Combustible')) {
                    $modelo .= 'Combustible';
                } elseif ($ksf == 'Embalse' || $ksf == 'Mineria' || $ksf == 'Industrial' || $ksf == 'Residuo_organizacional' || $ksf == 'Residuo') {
                    $modelo .= 'Emision';
                } elseif ($ksf == 'Cal') {
                    $modelo .= 'Fertilizante';
                } elseif ($ksf == 'Energia_electrica') {
                    $modelo .= 'Electricidad';
                } elseif ($ksf == 'Materia_prima') {
                    $modelo .= 'Aislamiento';
                } elseif ($ksf == 'Transporte') {
                    $modelo .= 'Viaje';
                } elseif ($ksf == 'Equipo') {
                    $modelo .= 'Fuga';
                } else {
                    $modelo .= $ksf;
                }

                foreach ($sf as $v) {
                    if ($v != -1) {
                        $fuente_emision = new FuenteEmision;
                        $fuente_emision->tipo = $ke;
                        $fuente_emision->fuente_emision = $ksf;
                        $fuente_emision->fuentetable_type = $modelo;
                        $fuente_emision->fuentetable_id = $v;
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

    // public function guardarProcesos($procesos)
    // {
    // foreach ($procesos["procesos"] as $p) {
    //     //Crear proceso
    //     $proceso = new Proceso;
    //     //por validar el id de la empresa, sede e informacion si se envia desde el vue
    //     $proceso->informacion_empresa_id = 1;
    //     $proceso->empresa_id = 1;
    //     $proceso->sede_id = 1;
    //     $proceso->nombre = $p['nombre'];
    //     $proceso->save();
    //     foreach ($p["subprocesos"] as $sp) {
    //         //Crear subproceso
    //         $subproceso = new Subproceso;
    //         $subproceso->nombre = $sp['nombre'];
    //         $subproceso->descripcion = $sp['descripcion'];
    //         $subproceso->proceso_id = $proceso->id;
    //         //por validar el id de la empresa y sede se envia desde el vue
    //         $subproceso->empresa_id = 1;
    //         $subproceso->sede_id = 1;
    //         $subproceso->save();

    //         foreach ($sp as $kf => $fuente) {
    //             if ($kf != 'nombre' && $kf != 'descripcion') {
    //                 foreach ($fuente as $ksf => $sf) {
    //                     foreach ($sf as $v) {
    //                         if ($v != -1) {
    //                             //Crear fuente emision
    //                             $fuente_emision = new FuenteEmision;
    //                             $fuente_emision->tipo = $kf;
    //                             $fuente_emision->fuente_emision = $ksf;

    //                             $modelo = '';
    //                             if (str_contains($ksf, 'combustibles')) {
    //                                 $modelo = 'combustibles';
    //                             } elseif ($ksf == 'embalses' || $ksf == 'minerias' || $ksf == 'industriales' || $ksf == 'residuos_organizacionales') {
    //                                 $modelo = 'emisiones';
    //                             } elseif ($ksf == 'cales') {
    //                                 $modelo = 'fertilizantes';
    //                             } elseif ($ksf == 'residuos_agropecuarios') {
    //                                 $modelo = 'estiercoles';
    //                             } else {
    //                                 $modelo = $ksf;
    //                             }

    //                             $fuente_emision->modelo = $modelo;
    //                             $fuente_emision->modelo_id = $v;
    //                             $fuente_emision->subproceso_id = $subproceso->id;
    //                             //por validar el id de la empresa, sede e informacion se envia desde el vue
    //                             $fuente_emision->informacion_empresa_id = 1;
    //                             $fuente_emision->empresa_id = 1;
    //                             $fuente_emision->sede_id = 1;
    //                             $fuente_emision->save();
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }
    // }
}
