<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Emision;
use App\Repositories\EmisionRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class EmisionController.
 */
class EmisionController extends Controller
{

    /**
     * @var EmisionRepository
     */
    protected $emisionRepository;

    /**
     * EmisionController constructor.
     *
     * @param  EmisionRepository  $emisionRepository
     */
    public function __construct(EmisionRepository $emisionRepository)
    {
        $this->emisionRepository = $emisionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(Emision::class)->allowedFilters([
            AllowedFilter::exact('tipo'),
        ]);
        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Emision $emision
     * @return \Illuminate\Http\Response
     */
    public function show(Emision $emision)
    {
        return QueryBuilder::for(Emision::whereId($emision->id))->first();
    }

    /**
     * Create a new Emision instance.
     */
    // protected function store(StoreEmisionRequest $data)
    // {
    //     return $this->emisionRepository->create($data->all());
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Emision $emision
     * @return \Illuminate\Http\Response
     */

    // public function update(UpdateEmisionRequest $request, $emision)
    // {
    //     return $this->emisionRepository->update($request, $emision);
    // }
}
