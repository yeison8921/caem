<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Fuga;
use Illuminate\Support\Facades\DB;

/**
 * Class FugaRepository.
 */
class FugaRepository extends BaseRepository
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
        return Fuga::class;
    }

    public function formFuga($id_fuga)
    {
        $data = [];
        $data['id_fuga'] = $id_fuga;
        if ($id_fuga != '') {
            $data['accion'] = 'Actualizar';
        } else {
            $data['accion'] = 'Crear';
        }
        return view('fuente/fuga/form_fuga', $data);
    }

    /**
     * @param array $data
     *
     * @return Fuga
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data): Fuga
    {
        return DB::transaction(function () use ($data) {
            $fuga = Fuga::create($data);
            if ($fuga) {
                return $fuga;
            }

            throw new GeneralException(__('backend_fugas.exceptions.create_error'));
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id_fuga)
    {
        $fuga = Fuga::find($id_fuga);
        $fuga->update($request->all());
        return $fuga;
    }
}
