<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Lubricante;
use Illuminate\Support\Facades\DB;

/**
 * Class LubricanteRepository.
 */
class LubricanteRepository extends BaseRepository
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
        return Lubricante::class;
    }

    public function formLubricante($id_lubricante)
    {
        $data = [];
        $data['id_lubricante'] = $id_lubricante;
        if ($id_lubricante != '') {
            $data['accion'] = 'Actualizar';
        } else {
            $data['accion'] = 'Crear';
        }
        return view('fuente/lubricante/form_lubricante', $data);
    }

    /**
     * @param array $data
     *
     * @return Lubricante
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data): Lubricante
    {
        return DB::transaction(function () use ($data) {
            $lubricante = Lubricante::create($data);
            if ($lubricante) {
                return $lubricante;
            }

            throw new GeneralException(__('backend_Lubricantes.exceptions.create_error'));
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id_lubricante)
    {
        $lubricante = Lubricante::find($id_lubricante);
        $lubricante->update($request->all());
        return $lubricante;
    }
}
