<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Lubricante\StoreLubricanteRequest;
use App\Http\Requests\Api\Lubricante\UpdateLubricanteRequest;
use App\Models\Lubricante;
use App\Models\User;
use App\Repositories\LubricanteRepository;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class LubricanteController.
 */
class LubricanteController extends Controller
{
    /**
     * @var LubricanteRepository
     */
    protected $lubricanteRepository;

    /**
     * LubricanteController constructor.
     *
     * @param  LubricanteRepository  $lubricanteRepository
     */
    public function __construct(LubricanteRepository $lubricanteRepository)
    {
        $this->lubricanteRepository = $lubricanteRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(Lubricante::class);

        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lubricante $lubricante
     * @return \Illuminate\Http\Response
     */
    public function show(Lubricante $lubricante)
    {
        return QueryBuilder::for(Lubricante::whereId($lubricante->id))->first();
    }

    public function formLubricante($id_lubricante = '')
    {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN])) {
            return $this->lubricanteRepository->formLubricante($id_lubricante);
        }

        return redirect()->route('welcome')->withFlashDanger(__('You do not have access to do that.'));
    }

    /**
     * Create a new Lubricante instance.
     */
    protected function store(StoreLubricanteRequest $data)
    {
        return $this->lubricanteRepository->create($data->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lubricante $lubricante
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLubricanteRequest $request, $lubricante)
    {
        return $this->lubricanteRepository->update($request, $lubricante);
    }
}
