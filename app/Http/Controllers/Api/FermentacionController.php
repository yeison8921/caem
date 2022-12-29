<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Fermentacion\StoreFermentacionRequest;
use App\Http\Requests\Api\Fermentacion\UpdateFermentacionRequest;
use App\Models\Fermentacion;
use App\Models\User;
use App\Repositories\FermentacionRepository;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class FermentacionController.
 */
class FermentacionController extends Controller
{
    /**
     * @var FermentacionRepository
     */
    protected $fermentacionRepository;

    /**
     * FermentacionController constructor.
     *
     * @param  FermentacionRepository  $fermentacionRepository
     */
    public function __construct(FermentacionRepository $fermentacionRepository)
    {
        $this->fermentacionRepository = $fermentacionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(Fermentacion::class);

        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fermentacion $fermentacione
     * @return \Illuminate\Http\Response
     */
    public function show(Fermentacion $fermentacione)
    {
        return QueryBuilder::for(Fermentacion::whereId($fermentacione->id))->first();
    }

    public function formFermentacion($id_fermentacion = '')
    {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN])) {
            return $this->fermentacionRepository->formFermentacion($id_fermentacion);
        }

        return redirect()->route('welcome')->withFlashDanger(__('You do not have access to do that.'));
    }

    /**
     * Create a new Fermentacion instance.
     */
    protected function store(StoreFermentacionRequest $data)
    {
        return $this->fermentacionRepository->create($data->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fermentacion $fermentacion
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFermentacionRequest $request, $fermentacion)
    {
        return $this->fermentacionRepository->update($request, $fermentacion);
    }
}
