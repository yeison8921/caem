<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fertilizante;
use App\Repositories\FertilizanteRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class FertilizanteController.
 */
class FertilizanteController extends Controller
{

    /**
     * @var FertilizanteRepository
     */
    protected $FertilizanteRepository;

    /**
     * FertilizanteController constructor.
     *
     * @param  FertilizanteRepository  $FertilizanteRepository
     */
    public function __construct(FertilizanteRepository $fertilizanteRepository)
    {
        $this->fertilizanteRepository = $fertilizanteRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(Fertilizante::class)->allowedFilters([
            AllowedFilter::exact('tipo'),
        ]);
        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fertilizante $fertilizante
     * @return \Illuminate\Http\Response
     */
    public function show(Fertilizante $fertilizante)
    {
        return QueryBuilder::for(Fertilizante::whereId($fertilizante->id))->first();
    }

    /**
     * Create a new Fertilizante instance.
     */
    // protected function store(StoreFertilizanteRequest $data)
    // {
    //     return $this->fertilizanteRepository->create($data->all());
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fertilizante $fertilizante
     * @return \Illuminate\Http\Response
     */

    // public function update(UpdateFertilizanteRequest $request, $fertilizante)
    // {
    //     return $this->fertilizanteRepository->update($request, $fertilizante);
    // }
}
