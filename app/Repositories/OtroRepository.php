<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Otro;
use Illuminate\Support\Facades\DB;

/**
 * Class OtroRepository.
 */
class OtroRepository extends BaseRepository
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
        return Otro::class;
    }

    public function formOtro($id_otro)
    {
        $data = [];
        $data['id_otro'] = $id_otro;
        if ($id_otro != '') {
            $data['accion'] = 'Actualizar';
        } else {
            $data['accion'] = 'Crear';
        }
        return view('fuente/Otro/form_Otro', $data);
    }

    /**
     * @param array $data
     *
     * @return Otro
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data): Otro
    {
        return DB::transaction(function () use ($data) {
            $otro = Otro::create($data);
            if ($otro) {
                return $otro;
            }

            throw new GeneralException(__('backend_otros.exceptions.create_error'));
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id_otro)
    {
        $otro = Otro::find($id_otro);
        $otro->update($request->all());
        return $otro;
    }
}
