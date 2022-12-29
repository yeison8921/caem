<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Electricidad\StoreElectricidadRequest;
use App\Http\Requests\Api\Electricidad\UpdateElectricidadRequest;
use App\Models\Electricidad;
use App\Models\User;
use App\Repositories\ElectricidadRepository;
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
        $query = QueryBuilder::for(Electricidad::class);

        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Electricidad $electricidade
     * @return \Illuminate\Http\Response
     */
    public function show(Electricidad $electricidade)
    {
        return QueryBuilder::for(Electricidad::whereId($electricidade->id))->first();
    }

    public function formElectricidad($id_electricidad = '')
    {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN])) {
            return $this->electricidadRepository->formElectricidad($id_electricidad);
        }

        return redirect()->route('welcome')->withFlashDanger(__('You do not have access to do that.'));
    }

    /**
     * Create a new Electricidad instance.
     */
    protected function store(StoreElectricidadRequest $data)
    {
        return $this->electricidadRepository->create($data->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Electricidad $electricidad
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateElectricidadRequest $request, $electricidad)
    {
        return $this->electricidadRepository->update($request, $electricidad);
    }
}
