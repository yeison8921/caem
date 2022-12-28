<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Emision;
use Illuminate\Support\Facades\DB;

/**
 * Class EmisionRepository.
 */
class EmisionRepository extends BaseRepository
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
        return Emision::class;
    }

    public function formEmision($tipo, $id_emision)
    {
        $data = [];
        $data['id_emision'] = $id_emision;
        $data['tipo'] = $tipo;
        if ($id_emision != '') {
            $data['accion'] = 'Actualizar';
        } else {
            $data['accion'] = 'Crear';
        }
        return view('fuente/emision/form_emision', $data);
    }

    /**
     * @param array $data
     *
     * @return Emision
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data): Emision
    {
        return DB::transaction(function () use ($data) {
            $emision = Emision::create($data);
            if ($emision) {
                return $emision;
            }

            throw new GeneralException(__('backend_emisiones.exceptions.create_error'));
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id_emision)
    {
        $emision = Emision::find($id_emision);
        $emision->update($request->all());
        return $emision;
    }
}
