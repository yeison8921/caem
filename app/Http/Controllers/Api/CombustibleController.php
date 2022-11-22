<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Combustible;
use App\Repositories\CombustibleRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class CombustibleController.
 */
class CombustibleController extends Controller
{

    /**
     * @var CombustibleRepository
     */
    protected $combustibleRepository;

    /**
     * CombustibleController constructor.
     *
     * @param  CombustibleRepository  $combustibleRepository
     */
    public function __construct(CombustibleRepository $combustibleRepository)
    {
        $this->combustibleRepository = $combustibleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(Combustible::class)->allowedFilters([
            AllowedFilter::exact('tipo'),
        ]);
        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Combustible $combustible
     * @return \Illuminate\Http\Response
     */
    public function show(Combustible $combustible)
    {
        return QueryBuilder::for(Combustible::whereId($combustible->id))->first();
    }

    /**
     * Create a new combustible instance.
     */
    // protected function store(StoreCombustibleRequest $data)
    // {
    //     return $this->combustibleRepository->create($data->all());
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Combustible $combustible
     * @return \Illuminate\Http\Response
     */

    // public function update(UpdateCombustibleRequest $request, $combustible)
    // {
    //     return $this->combustibleRepository->update($request, $combustible);
    // }
}
