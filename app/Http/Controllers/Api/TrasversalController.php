<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Trasversal\StoreTrasversalRequest;
use App\Http\Requests\Api\Trasversal\UpdateTrasversalRequest;
use App\Models\Trasversal;
use App\Models\User;
use App\Repositories\TrasversalRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class TrasversalController.
 */
class TrasversalController extends Controller
{
    /**
     * @var TrasversalRepository
     */
    protected $trasversalRepository;

    /**
     * TrasversalController constructor.
     *
     * @param  TrasversalRepository  $trasversalRepository
     */
    public function __construct(TrasversalRepository $trasversalRepository)
    {
        $this->trasversalRepository = $trasversalRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(Trasversal::class);

        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Trasversal $trasversale
     * @return \Illuminate\Http\Response
     */
    public function show(Trasversal $trasversale)
    {
        return QueryBuilder::for(Trasversal::whereId($trasversale->id))->first();
    }

    public function formTrasversal($id_trasversal = '')
    {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN])) {
            return $this->trasversalRepository->formTrasversal($id_trasversal);
        }

        return redirect()->route('welcome')->withFlashDanger(__('You do not have access to do that.'));
    }

    /**
     * Create a new Trasversal instance.
     */
    protected function store(StoreTrasversalRequest $data)
    {
        return $this->trasversalRepository->create($data->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Trasversal $trasversal
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateTrasversalRequest $request, $trasversal)
    {
        return $this->trasversalRepository->update($request, $trasversal);
    }
}
