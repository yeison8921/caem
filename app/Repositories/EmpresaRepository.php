<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Empresa;
use App\Models\EmpresaSede;
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

    public function getOptionsEmpresasSedes($empresa_id)
    {
        $sedes = EmpresaSede::where("empresa_id", $empresa_id)->get(['id as value', 'nombre as label']);
        return $sedes;
    }
}
