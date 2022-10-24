<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\EmpresaSede;
use Illuminate\Support\Facades\DB;

/**
 * Class EmpresaSedeRepository.
 */
class EmpresaSedeRepository extends BaseRepository
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
        return EmpresaSede::class;
    }

    /**
     * @param array $data
     *
     * @return EmpresaSede
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data): EmpresaSede
    {
        return DB::transaction(function () use ($data) {
            $empresa_sede = EmpresaSede::create($data);
            if ($empresa_sede) {
                return $empresa_sede;
            }

            throw new GeneralException(__('backend_empresas_sede.exceptions.create_error'));
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id_empresa_sede)
    {
        $empresa_sede = EmpresaSede::find($id_empresa_sede);
        $empresa_sede->update($request->all());
        return $empresa_sede;
    }

    public function formSede($id_sede, $empresa_id){
        $data = [];
        if($empresa_id == ''){
            $data['id_sede'] = $id_sede;
            $data['accion'] = 'Actualizar';
        }else{
            $data['empresa_id'] = $empresa_id;
            $data['accion'] = 'Crear';
        }
        return view('administracion/sede/form_sede', $data);
    }
}
