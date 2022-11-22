<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Refrigerante;
use App\Repositories\RefrigeranteRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class RefrigeranteController.
 */
class RefrigeranteController extends Controller
{

    /**
     * @var RefrigeranteRepository
     */
    protected $refrigeranteRepository;

    /**
     * RefrigeranteController constructor.
     *
     * @param  RefrigeranteRepository  $refrigeranteRepository
     */
    public function __construct(RefrigeranteRepository $refrigeranteRepository)
    {
        $this->refrigeranteRepository = $refrigeranteRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(Refrigerante::class);
        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Refrigerante $refrigerante
     * @return \Illuminate\Http\Response
     */
    public function show(Refrigerante $refrigerante)
    {
        return QueryBuilder::for(Refrigerante::whereId($refrigerante->id))->first();
    }

    /**
     * Create a new Refrigerante instance.
     */
    // protected function store(StoreRefrigeranteRequest $data)
    // {
    //     return $this->refrigeranteRepository->create($data->all());
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Refrigerante $refrigerante
     * @return \Illuminate\Http\Response
     */

    // public function update(UpdateRefrigeranteRequest $request, $refrigerante)
    // {
    //     return $this->refrigeranteRepository->update($request, $refrigerante);
    // }
}
