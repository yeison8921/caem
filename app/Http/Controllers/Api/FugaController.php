<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fuga;
use App\Repositories\FugaRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class FugaController.
 */
class FugaController extends Controller
{

    /**
     * @var FugaRepository
     */
    protected $fugaRepository;

    /**
     * FugaController constructor.
     *
     * @param  FugaRepository  $fugaRepository
     */
    public function __construct(FugaRepository $fugaRepository)
    {
        $this->fugaRepository = $fugaRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(Fuga::class)->allowedFilters([
            AllowedFilter::exact('tipo'),
        ]);
        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fuga $fuga
     * @return \Illuminate\Http\Response
     */
    public function show(Fuga $fuga)
    {
        return QueryBuilder::for(Fuga::whereId($fuga->id))->first();
    }

    /**
     * Create a new Fuga instance.
     */
    // protected function store(StoreFugaRequest $data)
    // {
    //     return $this->fugaRepository->create($data->all());
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fuga $fuga
     * @return \Illuminate\Http\Response
     */

    // public function update(UpdateFugaRequest $request, $fuga)
    // {
    //     return $this->fugaRepository->update($request, $fuga);
    // }
}
