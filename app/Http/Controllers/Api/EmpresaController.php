<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Empresa\StoreEmpresaRequest;
use App\Http\Requests\Api\Empresa\UpdateEmpresaRequest;
use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\EmpresaSede;
use App\Repositories\EmpresaRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class EmpresaController.
 */
class EmpresaController extends Controller
{

    /**
     * @var EmpresaRepository
     */
    protected $empresaRepository;

    /**
     * EmpresaController constructor.
     *
     * @param  EmpresaRepository  $empresaRepository
     */
    public function __construct(EmpresaRepository $empresaRepository)
    {
        $this->empresaRepository = $empresaRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(Empresa::class)->allowedFilters([
            AllowedFilter::exact('nit'),
            AllowedFilter::exact('convenio_id'),
        ])->allowedIncludes("sedes", "convenio");
        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empresa $empresa
     * @return \Illuminate\Http\Response
     */
    public function show(Empresa $empresa)
    {
        return QueryBuilder::for(Empresa::whereId($empresa->id))->allowedIncludes("codigo",
        "sector",
        "empleado",
        "tamano",
        "convenio",
        "convenio", "sedes")->first();
    }

    /**
     * Create a new empresa instance.
     */
    protected function store(StoreEmpresaRequest $data)
    {
        return $this->empresaRepository->create($data->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empresa $empresa
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateEmpresaRequest $request, $empresa)
    {
        return $this->empresaRepository->update($request, $empresa);
    }

    public function formEmpresa($id_empresa){
        return $this->empresaRepository->formEmpresa($id_empresa);
    }
}