<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fermentacion;
use App\Repositories\FermentacionRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class FermentacionController.
 */
class FermentacionController extends Controller
{

    /**
     * @var FermentacionRepository
     */
    protected $fermentacionRepository;

    /**
     * FermentacionController constructor.
     *
     * @param  FermentacionRepository  $fermentacionRepository
     */
    public function __construct(FermentacionRepository $fermentacionRepository)
    {
        $this->fermentacionRepository = $fermentacionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(Fermentacion::class);
        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fermentacion $fermentacion
     * @return \Illuminate\Http\Response
     */
    public function show(Fermentacion $fermentacion)
    {
        return QueryBuilder::for(Fermentacion::whereId($fermentacion->id))->first();
    }

    /**
     * Create a new Fermentacion instance.
     */
    // protected function store(StoreFermentacionRequest $data)
    // {
    //     return $this->fermentacionRepository->create($data->all());
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fermentacion $fermentacion
     * @return \Illuminate\Http\Response
     */

    // public function update(UpdateFermentacionRequest $request, $fermentacion)
    // {
    //     return $this->fermentacionRepository->update($request, $fermentacion);
    // }
}
