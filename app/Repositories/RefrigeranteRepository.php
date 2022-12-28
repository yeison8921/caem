<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Refrigerante;
use Illuminate\Support\Facades\DB;

/**
 * Class RefrigeranteRepository.
 */
class RefrigeranteRepository extends BaseRepository
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
        return Refrigerante::class;
    }

    public function formRefrigerante($id_refrigerante)
    {
        $data = [];
        $data['id_refrigerante'] = $id_refrigerante;
        if ($id_refrigerante != '') {
            $data['accion'] = 'Actualizar';
        } else {
            $data['accion'] = 'Crear';
        }
        return view('fuente/refrigerante/form_refrigerante', $data);
    }

    /**
     * @param array $data
     *
     * @return Refrigerante
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data): Refrigerante
    {
        return DB::transaction(function () use ($data) {
            $refrigerante = Refrigerante::create($data);
            if ($refrigerante) {
                return $refrigerante;
            }

            throw new GeneralException(__('backend_refrigerantes.exceptions.create_error'));
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id_refrigerante)
    {
        $refrigerante = Refrigerante::find($id_refrigerante);
        $refrigerante->update($request->all());
        return $refrigerante;
    }
}
