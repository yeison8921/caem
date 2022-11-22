<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lubricante;
use App\Repositories\LubricanteRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class LubricanteController.
 */
class LubricanteController extends Controller
{

    /**
     * @var LubricanteRepository
     */
    protected $lubricanteRepository;

    /**
     * LubricanteController constructor.
     *
     * @param  LubricanteRepository  $lubricanteRepository
     */
    public function __construct(LubricanteRepository $lubricanteRepository)
    {
        $this->lubricanteRepository = $lubricanteRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(Lubricante::class);
        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lubricante $lubricante
     * @return \Illuminate\Http\Response
     */
    public function show(Lubricante $lubricante)
    {
        return QueryBuilder::for(Lubricante::whereId($lubricante->id))->first();
    }

    /**
     * Create a new Lubricante instance.
     */
    // protected function store(StoreLubricanteRequest $data)
    // {
    //     return $this->lubricanteRepository->create($data->all());
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lubricante $lubricante
     * @return \Illuminate\Http\Response
     */

    // public function update(UpdateLubricanteRequest $request, $lubricante)
    // {
    //     return $this->lubricanteRepository->update($request, $lubricante);
    // }
}
