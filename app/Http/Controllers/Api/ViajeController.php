<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Viaje;
use App\Http\Requests\Api\Viaje\StoreViajeRequest;
use App\Http\Requests\Api\Viaje\UpdateViajeRequest;
use App\Repositories\ViajeRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class ViajeController.
 */
class ViajeController extends Controller
{

    /**
     * @var ViajeRepository
     */
    protected $viajeRepository;

    /**
     * ViajeController constructor.
     *
     * @param  ViajeRepository  $viajeRepository
     */
    public function __construct(ViajeRepository $viajeRepository)
    {
        $this->vaijeRepository = $viajeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(Viaje::class);
        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Viaje $viaje
     * @return \Illuminate\Http\Response
     */
    public function show(Viaje $viaje)
    {
        return QueryBuilder::for(Viaje::whereId($viaje->id))->first();
    }

    public function formViaje($id_viaje = '')
    {
        return $this->vaijeRepository->formViaje($id_viaje);
    }

    /**
     * Create a new Viaje instance.
     */
    protected function store(StoreViajeRequest $data)
    {
        return $this->vaijeRepository->create($data->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Viaje $viaje
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateViajeRequest $request, $viaje)
    {
        return $this->vaijeRepository->update($request, $viaje);
    }
}
