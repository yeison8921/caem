<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\InformacionEmpresa;
use Illuminate\Support\Facades\DB;

/**
 * Class InformacionEmpresaRepository.
 */
class InformacionEmpresaRepository extends BaseRepository
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
        return InformacionEmpresa::class;
    }

    /**
     * @param array $data
     *
     * @return InformacionEmpresa
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data): InformacionEmpresa
    {
        return DB::transaction(function () use ($data) {
            $informacion_pregunta = InformacionEmpresa::create($data);
            if ($informacion_pregunta) {
                return $informacion_pregunta;
            }

            throw new GeneralException(__('backend_informacion_empresas.exceptions.create_error'));
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id)
    {
        $informacion = InformacionEmpresa::find($id);
        $informacion->update($request->all());
        return $informacion;
    }
}
