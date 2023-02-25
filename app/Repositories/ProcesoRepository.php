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

            foreach ($request['procesos'] as $p) {
                if ($p['id'] != '') {
                    array_push($array_procesos, $p['id']);
                }
                foreach ($p['subprocesos'] as $kp => $sp) {
                    if ($sp['id'] != '') {
                        array_push($array_subprocesos, $sp['id']);
                    }
                }
            }

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
