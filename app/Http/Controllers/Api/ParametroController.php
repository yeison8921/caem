<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Parametro\StoreParametroRequest;
use App\Http\Requests\Api\Parametro\UpdateParametroRequest;
use App\Repositories\ParametroRepository;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Parametro;
//use Spatie\QueryBuilder\AllowedFilter;

/**
 * Class ParametroController.
 */
class ParametroController extends Controller
{
    /**
     * @var ParametroRepository
     */
    protected $parametroRepository;

    /**
     * ParametroController constructor.
     *
     * @param  ParametroRepository  $parametroRepository
     */
    public function __construct(ParametroRepository $parametroRepository)
    {
        $this->parametroRepository = $parametroRepository;
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(Parametro::class)
            ->allowedFilters([
             'tipo_parametro_id',
             'parametro_id'
            ])->allowedIncludes([
                'parametro',
            ]);

        if (request('limit')) {
            return $query->paginate(request('limit') ?? 15);
        }

        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Parametro $parametro
     * @return \Illuminate\Http\Response
     */
    public function show(Parametro $parametro)
    {
        return QueryBuilder::for(Parametro::whereId($parametro->id))
        ->allowedFields(['nombre'])
        ->first();
    }

    /**
     * Create a new parametro instance after a valid registration.
     */
    protected function store(StoreParametroRequest $data)
    {
        return $this->parametroRepository->create($data->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Parametro $parametro
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateParametroRequest $request, $parametro)
    {
        return $this->parametroRepository->update($request, $parametro);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Parametro  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parametro $parametro)
    {
        return $parametro->delete();
    }

    public function formParametro($tipo_parametro_id, $id_parametro=''){
        return $this->parametroRepository->formParametro($tipo_parametro_id, $id_parametro);
    }
}
