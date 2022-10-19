<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Parametro;
use Illuminate\Support\Facades\DB;


/**
 * Class ParametroRepository.
 */
class ParametroRepository extends BaseRepository
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
        return Parametro::class;
    }

    /**
     * @param array $data
     *
     * @return Parametro
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data): Parametro
    {
        return DB::transaction(function () use ($data) {
            $parametro = Parametro::create($data);
            if ($parametro) {
                return $parametro;
            }

            throw new GeneralException(__('backend_parametros.exceptions.create_error'));
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id_parametro)
    {
        $empresa = Parametro::find($id_parametro);
        $empresa->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Parametro $parametro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parametro $parametro)
    {
        return $parametro->delete();
    }

    public function formParametro($tipo_parametro_id, $id_parametro){
        
        $data = [];
        $data['tipo_parametro_id'] = $tipo_parametro_id;
        if($id_parametro != ''){
            $data['accion'] = 'Actualizar';
            $data['id_parametro'] = $id_parametro;
        }else{
            $data['accion'] = 'Crear';
        }
        return view('administracion/parametro/form_parametro', $data);
    }
}
