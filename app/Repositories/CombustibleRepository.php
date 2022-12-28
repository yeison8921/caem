<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Combustible;
use Illuminate\Support\Facades\DB;

/**
 * Class CombustibleRepository.
 */
class CombustibleRepository extends BaseRepository
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
        return Combustible::class;
    }

    /**
     * @param array $data
     *
     * @return Combustible
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data): Combustible
    {
        return DB::transaction(function () use ($data) {
            $combustible = Combustible::create($data);
            if ($combustible) {
                return $combustible;
            }

            throw new GeneralException(__('backend_combustibles.exceptions.create_error'));
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id_combustible)
    {
        $combustible = Combustible::find($id_combustible);
        $combustible->update($request->all());
        return $combustible;
    }

    public function formCombustible($tipo, $id_combustible)
    {
        $data = [];
        $data['id_combustible'] = $id_combustible;
        $data['tipo'] = $tipo;
        if ($id_combustible != '') {
            $data['accion'] = 'Actualizar';
        } else {
            $data['accion'] = 'Crear';
        }
        return view('fuente/combustible/form_combustible', $data);
    }
}
