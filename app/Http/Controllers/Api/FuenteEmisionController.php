<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FuenteEmision;
use App\Repositories\FuenteEmisionRepository;
use App\Http\Requests\Api\FuenteEmision\UpdateFuenteEmisionRequest;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class FuenteEmisionController.
 */
class FuenteEmisionController extends Controller
{

    /**
     * @var FuenteEmisionRepository
     */
    protected $fuenteEmisionRepository;

    /**
     * FuenteEmisionController constructor.
     *
     * @param  FuenteEmisionRepository  $fuenteEmisionRepository
     */
    public function __construct(FuenteEmisionRepository $fuenteEmisionRepository)
    {
        $this->fuenteEmisionRepository = $fuenteEmisionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(FuenteEmision::class);
        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FuenteEmision $fuente_emision
     * @return \Illuminate\Http\Response
     */
    public function show(FuenteEmision $fuente_emision)
    {
        return QueryBuilder::for(FuenteEmision::whereId($fuente_emision->id))->first();
    }

    /**
     * Create a new FuenteEmision instance.
     */
    // protected function store(StoreFuenteEmisionRequest $data)
    // {
    //     return $this->fuenteEmisionRepository->create($data->all());
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\FuenteEmision $fuente_emision
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateFuenteEmisionRequest $request, $fuente_emision)
    {
        return $this->fuenteEmisionRepository->update($request, $fuente_emision);
    }
}