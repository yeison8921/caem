<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Electricidad;
use Illuminate\Support\Facades\DB;

/**
 * Class ElectricidadRepository.
 */
class ElectricidadRepository extends BaseRepository
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
        return Electricidad::class;
    }

    public function formElectricidad($id_electricidad)
    {
        $data = [];
        $data['id_electricidad'] = $id_electricidad;
        if ($id_electricidad != '') {
            $data['accion'] = 'Actualizar';
        } else {
            $data['accion'] = 'Crear';
        }
        return view('fuente/electricidad/form_electricidad', $data);
    }

    /**
     * @param array $data
     *
     * @return Electricidad
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data): Electricidad
    {
        return DB::transaction(function () use ($data) {
            $electricidad = Electricidad::create($data);
            if ($electricidad) {
                return $electricidad;
            }

            throw new GeneralException(__('backend_electricidades.exceptions.create_error'));
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id_electricidad)
    {
        $electricidad = Electricidad::find($id_electricidad);
        $electricidad->update($request->all());
        return $electricidad;
    }
}
