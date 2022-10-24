<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Empresa;
use App\Models\EmpresaSede;
use App\Models\EmpresaTemporal;
use Illuminate\Support\Facades\DB;

/**
 * Class EmpresaRepository.
 */
class EmpresaRepository extends BaseRepository
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
        return Empresa::class;
    }

    /**
     * @param array $data
     *
     * @return Empresa
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data): Empresa
    {
        return DB::transaction(function () use ($data) {
            $empresa = Empresa::create($data);
            if ($empresa) {
                return $empresa;
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
    public function update($request, $id_empresa)
    {
        $empresa = Empresa::find($id_empresa);
        $empresa->update($request->all());
        return $empresa;
    }

    public function formEmpresa($id_empresa){
        $data = [];
        $data['id_empresa'] = $id_empresa;
        return view('administracion/empresa/form_empresa', $data);
    }
}
