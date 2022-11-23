<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aislamiento;
use App\Repositories\AislamientoRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class AislamientoController.
 */
class AislamientoController extends Controller
{

    /**
     * @var AislamientoRepository
     */
    protected $aislamientoRepository;

    /**
     * AislamientoController constructor.
     *
     * @param  AislamientoRepository  $aislamientoRepository
     */
    public function __construct(AislamientoRepository $aislamientoRepository)
    {
        $this->aislamientoRepository = $aislamientoRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(Aislamiento::class)->allowedFilters([
            AllowedFilter::exact('tipo'),
        ]);
        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aislamiento $aislamiento
     * @return \Illuminate\Http\Response
     */
    public function show(Aislamiento $aislamiento)
    {
        return QueryBuilder::for(Aislamiento::whereId($aislamiento->id))->first();
    }

    /**
     * Create a new Aislamiento instance.
     */
    // protected function store(StoreAislamientoRequest $data)
    // {
    //     return $this->aislamientoRepository->create($data->all());
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Aislamiento $aislamiento
     * @return \Illuminate\Http\Response
     */

    // public function update(UpdateAislamientoRequest $request, $aislamiento)
    // {
    //     return $this->aislamientoRepository->update($request, $aislamiento);
    // }
}
