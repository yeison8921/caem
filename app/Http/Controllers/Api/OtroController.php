<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Otro\StoreOtroRequest;
use App\Http\Requests\Api\Otro\UpdateOtroRequest;
use App\Models\Otro;
use App\Models\User;
use App\Repositories\OtroRepository;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class OtroController.
 */
class OtroController extends Controller
{
    /**
     * @var OtroRepository
     */
    protected $otroRepository;

    /**
     * OtroController constructor.
     *
     * @param  OtroRepository  $otroRepository
     */
    public function __construct(OtroRepository $otroRepository)
    {
        $this->otroRepository = $otroRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(Otro::class);

        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Otro $otro
     * @return \Illuminate\Http\Response
     */
    public function show(Otro $otro)
    {
        return QueryBuilder::for(Otro::whereId($otro->id))->first();
    }

    public function formOtro($id_otro = '')
    {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN])) {
            return $this->otroRepository->formOtro($id_otro);
        }

        return redirect()->route('welcome')->withFlashDanger(__('You do not have access to do that.'));
    }

    /**
     * Create a new Otro instance.
     */
    protected function store(StoreOtroRequest $data)
    {
        return $this->otroRepository->create($data->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Otro $otro
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateOtroRequest $request, $otro)
    {
        return $this->otroRepository->update($request, $otro);
    }
}
