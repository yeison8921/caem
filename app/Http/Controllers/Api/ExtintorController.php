<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Extintor;
use App\Http\Requests\Api\Extintor\StoreExtintorRequest;
use App\Http\Requests\Api\Extintor\UpdateExtintorRequest;
use App\Repositories\ExtintorRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class ExtintorController.
 */
class ExtintorController extends Controller
{

    /**
     * @var ExtintorRepository
     */
    protected $extintorRepository;

    /**
     * ExtintorController constructor.
     *
     * @param  ExtintorRepository  $extintorRepository
     */
    public function __construct(ExtintorRepository $extintorRepository)
    {
        $this->extintorRepository = $extintorRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(Extintor::class);
        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Extintor $extintore
     * @return \Illuminate\Http\Response
     */
    public function show(Extintor $extintore)
    {
        return QueryBuilder::for(Extintor::whereId($extintore->id))->first();
    }

    public function formExtintor($id_extintor = '')
    {
        return $this->extintorRepository->formExtintor($id_extintor);
    }

    /**
     * Create a new Extintor instance.
     */
    protected function store(StoreExtintorRequest $data)
    {
        return $this->extintorRepository->create($data->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Extintor $extintor
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateExtintorRequest $request, $extintor)
    {
        return $this->extintorRepository->update($request, $extintor);
    }
}
