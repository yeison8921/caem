<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Sf6;
use Illuminate\Support\Facades\DB;

/**
 * Class Sf6Repository.
 */
class Sf6Repository extends BaseRepository
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
        return Sf6::class;
    }

    public function formSf6($id_sf6)
    {
        $data = [];
        $data['id_Sf6'] = $id_sf6;
        if ($id_sf6 != '') {
            $data['accion'] = 'Actualizar';
        } else {
            $data['accion'] = 'Crear';
        }
        return view('fuente/sf6/form_sf6', $data);
    }

    /**
     * @param array $data
     *
     * @return Sf6
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data): Sf6
    {
        return DB::transaction(function () use ($data) {
            $sf6 = Sf6::create($data);
            if ($sf6) {
                return $sf6;
            }

            throw new GeneralException(__('backend_sf6s.exceptions.create_error'));
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id_sf6)
    {
        $sf6 = Sf6::find($id_sf6);
        $sf6->update($request->all());
        return $sf6;
    }
}
