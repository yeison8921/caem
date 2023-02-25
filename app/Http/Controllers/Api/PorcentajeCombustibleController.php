<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PorcentajeCombustible\StorePorcentajeCombustibleRequest;
use App\Http\Requests\Api\PorcentajeCombustible\UpdatePorcentajeCombustibleRequest;
use App\Models\PorcentajeCombustible;
use App\Models\User;
use App\Repositories\PorcentajeCombustibleRepository;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class PorcentajeCombustibleController.
 */
class PorcentajeCombustibleController extends Controller
{
    /**
     * @var PorcentajeCombustibleRepository
     */
    protected $porcentajeCombustibleRepository;

    /**
     * PorcentajeCombustibleController constructor.
     *
     * @param  PorcentajeCombustibleRepository  $porcentajeCombustibleRepository
     */
    public function __construct(PorcentajeCombustibleRepository $porcentajeCombustibleRepository)
    {
        $this->porcentajeCombustibleRepository = $porcentajeCombustibleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(PorcentajeCombustible::class);

        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PorcentajeCombustible $porcentajes_combustible
     * @return \Illuminate\Http\Response
     */
    public function show(PorcentajeCombustible $porcentajes_combustible)
    {
        return QueryBuilder::for(PorcentajeCombustible::whereId($porcentajes_combustible->id))->first();
    }

    public function formPorcentaje($id_porcentaje = '')
    {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN])) {
            return $this->porcentajeCombustibleRepository->formPorcentaje($id_porcentaje);
        }

        return redirect()->route('welcome')->withFlashDanger(__('You do not have access to do that.'));
    }

    /**
     * Create a new PorcentajeCombustible instance.
     */
    protected function store(StorePorcentajeCombustibleRequest $data)
    {
        return $this->porcentajeCombustibleRepository->create($data->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PorcentajeCombustible $porcentaje_combustible
     * @return \Illuminate\Http\Response
     */

    public function update(UpdatePorcentajeCombustibleRequest $request, $porcentaje_combustible)
    {
        return $this->porcentajeCombustibleRepository->update($request, $porcentaje_combustible);
    }
}
