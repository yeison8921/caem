<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Aislamiento;
use Illuminate\Support\Facades\DB;

/**
 * Class AislamientoRepository.
 */
class AislamientoRepository extends BaseRepository
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
        return Aislamiento::class;
    }

    public function formAislamiento($id_aislamiento)
    {
        $data = [];
        $data['id_aislamiento'] = $id_aislamiento;
        if ($id_aislamiento != '') {
            $data['accion'] = 'Actualizar';
        } else {
            $data['accion'] = 'Crear';
        }
        return view('fuente/aislamiento/form_aislamiento', $data);
    }

    /**
     * @param array $data
     *
     * @return Aislamiento
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data): Aislamiento
    {
        return DB::transaction(function () use ($data) {
            $aislamiento = Aislamiento::create($data);
            if ($aislamiento) {
                return $aislamiento;
            }

            throw new GeneralException(__('backend_aislamientos.exceptions.create_error'));
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id_aislamiento)
    {
        $aislamiento = Aislamiento::find($id_aislamiento);
        $aislamiento->update($request->all());
        return $aislamiento;
    }
}
