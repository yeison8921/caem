<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Fertilizante\StoreFertilizanteRequest;
use App\Http\Requests\Api\Fertilizante\UpdateFertilizanteRequest;
use App\Models\Fertilizante;
use App\Models\User;
use App\Repositories\FertilizanteRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class FertilizanteController.
 */
class FertilizanteController extends Controller
{
    /**
     * @var FertilizanteRepository
     */
    protected $FertilizanteRepository;

    /**
     * FertilizanteController constructor.
     *
     * @param  FertilizanteRepository  $FertilizanteRepository
     */
    public function __construct(FertilizanteRepository $fertilizanteRepository)
    {
        $this->fertilizanteRepository = $fertilizanteRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(Fertilizante::class)->allowedFilters([
            AllowedFilter::exact('tipo'),
        ]);

        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fertilizante $fertilizante
     * @return \Illuminate\Http\Response
     */
    public function show(Fertilizante $fertilizante)
    {
        return QueryBuilder::for(Fertilizante::whereId($fertilizante->id))->first();
    }

    public function formFertilizante($tipo, $id_emision = '')
    {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN])) {
            return $this->fertilizanteRepository->formFertilizante($tipo, $id_emision);
        }

        return redirect()->route('welcome')->withFlashDanger(__('You do not have access to do that.'));
    }

    /**
     * Create a new Fertilizante instance.
     */
    protected function store(StoreFertilizanteRequest $data)
    {
        return $this->fertilizanteRepository->create($data->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fertilizante $fertilizante
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateFertilizanteRequest $request, $fertilizante)
    {
        return $this->fertilizanteRepository->update($request, $fertilizante);
    }
}
