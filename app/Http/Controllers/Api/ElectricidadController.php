<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Electricidad;
use App\Repositories\ElectricidadRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class ElectricidadController.
 */
class ElectricidadController extends Controller
{

    /**
     * @var ElectricidadRepository
     */
    protected $electricidadRepository;

    /**
     * ElectricidadController constructor.
     *
     * @param  ElectricidadRepository  $electricidadRepository
     */
    public function __construct(ElectricidadRepository $electricidadRepository)
    {
        $this->electricidadRepository = $electricidadRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(Electricidad::class)->allowedFilters([
            AllowedFilter::exact('tipo'),
        ]);
        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Electricidad $electricidad
     * @return \Illuminate\Http\Response
     */
    public function show(Electricidad $electricidad)
    {
        return QueryBuilder::for(Electricidad::whereId($electricidad->id))->first();
    }

    /**
     * Create a new Electricidad instance.
     */
    // protected function store(StoreElectricidadRequest $data)
    // {
    //     return $this->electricidadRepository->create($data->all());
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Electricidad $electricidad
     * @return \Illuminate\Http\Response
     */

    // public function update(UpdateElectricidadRequest $request, $electricidad)
    // {
    //     return $this->electricidadRepository->update($request, $electricidad);
    // }
}
