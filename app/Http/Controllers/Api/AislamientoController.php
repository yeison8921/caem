<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Aislamiento\StoreAislamientoRequest;
use App\Http\Requests\Api\Aislamiento\UpdateAislamientoRequest;
use App\Models\Aislamiento;
use App\Models\User;
use App\Repositories\AislamientoRepository;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class AislamientoController.
 */
class AislamientoController extends Controller
{
    /**
     * @var AislamientoRepository
     */
    protected $aislamientoRepository;

    /**
     * AislamientoController constructor.
     *
     * @param  AislamientoRepository  $aislamientoRepository
     */
    public function __construct(AislamientoRepository $aislamientoRepository)
    {
        $this->aislamientoRepository = $aislamientoRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(Aislamiento::class);

        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aislamiento $aislamiento
     * @return \Illuminate\Http\Response
     */
    public function show(Aislamiento $aislamiento)
    {
        return QueryBuilder::for(Aislamiento::whereId($aislamiento->id))->first();
    }

    public function formAislamiento($id_aislamiento = '')
    {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN])) {
            return $this->aislamientoRepository->formAislamiento($id_aislamiento);
        }

        return redirect()->route('welcome')->withFlashDanger(__('You do not have access to do that.'));
    }

    /**
     * Create a new Aislamiento instance.
     */
    protected function store(StoreAislamientoRequest $data)
    {
        return $this->aislamientoRepository->create($data->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Aislamiento $aislamiento
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateAislamientoRequest $request, $aislamiento)
    {
        return $this->aislamientoRepository->update($request, $aislamiento);
    }
}
