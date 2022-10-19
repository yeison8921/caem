<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use App\Http\Requests\Api\UserRegister\StoreRegisterRequest;
use App\Models\TipoParametro;
use App\Repositories\TipoParametroRepository;
use Spatie\QueryBuilder\QueryBuilder;
//use Spatie\QueryBuilder\AllowedFilter;

/**
 * Class TipoParametroController.
 */
class TipoParametroController extends Controller
{
    /**
     * @var TipoParametroRepository
     */
    protected $tipoParametroRepository;

    /**
     * TipoParametroController constructor.
     *
     * @param TipoParametroRepository $tipoParametroRepository
     */
    public function __construct(TipoParametroRepository $tipoParametroRepository)
    {
        $this->parametroRepository = $tipoParametroRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(TipoParametro::class);

        if (request('limit')) {
            return $query->paginate(request('limit') ?? 15);
        }

        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipoParametro $tipo
     * @return \Illuminate\Http\Response
     */
    public function show(TipoParametro $tipo)
    {
        return QueryBuilder::for(TipoParametro::whereId($tipo->id))
        ->first();
    }
}
