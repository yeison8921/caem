<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Extintor;
use Illuminate\Support\Facades\DB;

/**
 * Class ExtintorRepository.
 */
class ExtintorRepository extends BaseRepository
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
        return Extintor::class;
    }

    public function formExtintor($id_extintor)
    {
        $data = [];
        $data['id_extintor'] = $id_extintor;
        if ($id_extintor != '') {
            $data['accion'] = 'Actualizar';
        } else {
            $data['accion'] = 'Crear';
        }
        return view('fuente/extintor/form_extintor', $data);
    }

    /**
     * @param array $data
     *
     * @return Extintor
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data): Extintor
    {
        return DB::transaction(function () use ($data) {
            $extintor = Extintor::create($data);
            if ($extintor) {
                return $extintor;
            }

            throw new GeneralException(__('backend_Extintores.exceptions.create_error'));
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id_extintor)
    {
        $extintor = Extintor::find($id_extintor);
        $extintor->update($request->all());
        return $extintor;
    }
}
