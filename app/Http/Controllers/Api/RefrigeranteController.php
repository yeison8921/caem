<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Refrigerante\StoreRefrigeranteRequest;
use App\Http\Requests\Api\Refrigerante\UpdateRefrigeranteRequest;
use App\Models\Refrigerante;
use App\Models\User;
use App\Repositories\RefrigeranteRepository;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class RefrigeranteController.
 */
class RefrigeranteController extends Controller
{
    /**
     * @var RefrigeranteRepository
     */
    protected $refrigeranteRepository;

    /**
     * RefrigeranteController constructor.
     *
     * @param  RefrigeranteRepository  $refrigeranteRepository
     */
    public function __construct(RefrigeranteRepository $refrigeranteRepository)
    {
        $this->refrigeranteRepository = $refrigeranteRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(Refrigerante::class);

        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Refrigerante $refrigerante
     * @return \Illuminate\Http\Response
     */
    public function show(Refrigerante $refrigerante)
    {
        return QueryBuilder::for(Refrigerante::whereId($refrigerante->id))->first();
    }

    public function formRefrigerante($id_refrigerante = '')
    {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN])) {
            return $this->refrigeranteRepository->formRefrigerante($id_refrigerante);
        }

        return redirect()->route('welcome')->withFlashDanger(__('You do not have access to do that.'));
    }

    /**
     * Create a new Refrigerante instance.
     */
    protected function store(StoreRefrigeranteRequest $data)
    {
        return $this->refrigeranteRepository->create($data->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Refrigerante $refrigerante
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateRefrigeranteRequest $request, $refrigerante)
    {
        return $this->refrigeranteRepository->update($request, $refrigerante);
    }
}
