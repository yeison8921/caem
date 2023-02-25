<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ResultadoFuenteEmision;
use App\Repositories\ResultadoFuenteEmisionRepository;
//use App\Http\Requests\Api\FuenteEmision\UpdateFuenteEmisionRequest;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class ResultadoFuenteEmisionController.
 */
class ResultadoFuenteEmisionController extends Controller
{

    /**
     * @var ResultadoFuenteEmisionRepository
     */
    protected $resultadoFuenteEmisionRepository;

    /**
     * ResultadoFuenteEmisionController constructor.
     *
     * @param  ResultadoFuenteEmisionRepository  $resultadoFuenteEmisionRepository
     */
    public function __construct(ResultadoFuenteEmisionRepository $resultadoFuenteEmisionRepository)
    {
        $this->resultadoFuenteEmisionRepository = $resultadoFuenteEmisionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(ResultadoFuenteEmision::class)->allowedFilters([
            AllowedFilter::exact('informacion_empresa_id')
        ]);
        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ResultadoFuenteEmision $resultado_fuente_emision
     * @return \Illuminate\Http\Response
     */
    public function show(ResultadoFuenteEmision $resultado_fuente_emision)
    {
        return QueryBuilder::for(ResultadoFuenteEmision::whereId($resultado_fuente_emision->id))->first();
    }

    /**
     * Create a new FuenteEmision instance.
     */
    // protected function store(StoreFuenteEmisionRequest $data)
    // {
    //     return $this->resultadoFuenteEmisionRepository->create($data->all());
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\FuenteEmision $resultado_fuente_emision
     * @return \Illuminate\Http\Response
     */

    // public function update(UpdateFuenteEmisionRequest $request, $resultado_fuente_emision)
    // {
    //     return $this->resultadoFuenteEmisionRepository->update($request, $resultado_fuente_emision);
    // }

    public function guardarDatosConsumos(Request $request)
    {
        return $this->resultadoFuenteEmisionRepository->guardarDatosConsumos($request);
    }

    public function getDatosGraficas(Request $request)
    {
        return $this->resultadoFuenteEmisionRepository->getDatosGraficas($request);
    }
}
