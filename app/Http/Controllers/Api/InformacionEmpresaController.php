<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\InformacionEmpresa\StoreInformacionEmpresaRequest;
use App\Http\Requests\Api\InformacionEmpresa\UpdateInformacionEmpresaRequest;
use Illuminate\Http\Request;
use App\Models\InformacionEmpresa;
use App\Repositories\InformacionEmpresaRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class InformacionEmpresaController.
 */
class InformacionEmpresaController extends Controller
{

    /**
     * @var InformacionEmpresaRepository
     */
    protected $informacionEmpresaRepository;

    /**
     * InformacionEmpresaController constructor.
     *
     * @param  InformacionEmpresaRepository  $informacionEmpresaRepository
     */
    public function __construct(InformacionEmpresaRepository $informacionEmpresaRepository)
    {
        $this->informacionEmpresaRepository = $informacionEmpresaRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(InformacionEmpresa::class);
        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InformacionEmpresa $informacion_empresa
     * @return \Illuminate\Http\Response
     */
    public function show(InformacionEmpresa $informacion_empresa)
    {
        return QueryBuilder::for(InformacionEmpresa::whereId($informacion_empresa->id))->first();
    }

    /**
     * Create a new informacion_empresa instance.
     */
    protected function store(StoreInformacionEmpresaRequest $data)
    {
        return $this->informacionEmpresaRepository->create($data->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\InformacionEmpresa $informacion_empresa
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateInformacionEmpresaRequest $request, $informacion_empresa)
    {
        return $this->informacionEmpresaRepository->update($request, $informacion_empresa);
    }
}
