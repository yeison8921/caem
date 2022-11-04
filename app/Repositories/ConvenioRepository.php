<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Convenio;
use App\Models\ConvenioEmail;
use Illuminate\Support\Facades\DB;

/**
 * Class ConvenioRepository.
 */
class ConvenioRepository extends BaseRepository
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
        return Convenio::class;
    }

    /**
     * @param array $data
     *
     * @return Convenio
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data): Convenio
    {
        return DB::transaction(function () use ($data) {
            $convenio = Convenio::create($data);
            if ($convenio) {
                return $convenio;
            }

            throw new GeneralException(__('backend_empresas.exceptions.create_error'));
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id_convenio)
    {
        $convenio = Convenio::find($id_convenio);
        $convenio->update($request->all());
        return $convenio;
    }

    public function formConvenio($id_convenio)
    {
        $data = [];
        $data['id_convenio'] = $id_convenio;
        if ($id_convenio != '') {
            $data['accion'] = 'Actualizar';
        } else {
            $data['accion'] = 'Crear';
        }
        return view('administracion/convenio/form_convenio', $data);
    }

    public function cambiarEstadoConvenio($request)
    {
        $request->estado ? Convenio::withTrashed()->find($request->id_convenio)->restore() : Convenio::find($request->id_convenio)->delete();
    }

    public function crearConvenioEmpresa($request)
    {
        $convenio = Convenio::find($request->convenio_id);
        $convenio->empresas()->detach($request->empresa_id);
        $convenio->empresas()->attach($request->empresa_id);
    }
}
