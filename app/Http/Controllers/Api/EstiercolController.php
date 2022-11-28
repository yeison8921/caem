<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Estiercol;
use App\Repositories\EstiercolRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class EstiercolController.
 */
class EstiercolController extends Controller
{

    /**
     * @var EstiercolRepository
     */
    protected $estiercolRepository;

    /**
     * EstiercolController constructor.
     *
     * @param  EstiercolRepository  $estiercolRepository
     */
    public function __construct(EstiercolRepository $estiercolRepository)
    {
        $this->estiercolRepository = $estiercolRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(Estiercol::class)->allowedFilters([
            AllowedFilter::exact('tipo'),
        ]);
        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Estiercol $estiercol
     * @return \Illuminate\Http\Response
     */
    public function show(Estiercol $estiercol)
    {
        return QueryBuilder::for(Estiercol::whereId($estiercol->id))->first();
    }

    /**
     * Create a new Estiercol instance.
     */
    // protected function store(StoreEstiercolRequest $data)
    // {
    //     return $this->estiercolRepository->create($data->all());
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Estiercol $estiercol
     * @return \Illuminate\Http\Response
     */

    // public function update(UpdateEstiercolRequest $request, $estiercol)
    // {
    //     return $this->estiercolRepository->update($request, $estiercol);
    // }
}
