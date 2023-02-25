<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\PorcentajeCombustible;
use Illuminate\Support\Facades\DB;

/**
 * Class PorcentajeCombustibleRepository.
 */
class PorcentajeCombustibleRepository extends BaseRepository
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
        return PorcentajeCombustible::class;
    }

    public function formPorcentaje($id_porcentaje)
    {
        $data = [];
        $data['id_porcentaje'] = $id_porcentaje;
        if ($id_porcentaje != '') {
            $data['accion'] = 'Actualizar';
        } else {
            $data['accion'] = 'Crear';
        }
        return view('fuente/porcentaje/form_porcentaje', $data);
    }

    /**
     * @param array $data
     *
     * @return PorcentajeCombustible
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data): PorcentajeCombustible
    {
        return DB::transaction(function () use ($data) {
            $porcentaje_combustible = PorcentajeCombustible::create($data);
            if ($porcentaje_combustible) {
                return $porcentaje_combustible;
            }

            throw new GeneralException(__('backend_PorcentajeCombustibles.exceptions.create_error'));
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id_porcentaje)
    {
        $porcentaje_combustible = PorcentajeCombustible::find($id_porcentaje);
        $porcentaje_combustible->update($request->all());
        return $porcentaje_combustible;
    }
}
