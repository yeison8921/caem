<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Proceso;
use App\Repositories\ProcesoRepository;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class ProcesoController.
 */
class ProcesoController extends Controller
{

    /**
     * @var ProcesoRepository
     */
    protected $procesoRepository;

    /**
     * ProcesoController constructor.
     *
     * @param  ProcesoRepository  $procesoRepository
     */
    public function __construct(ProcesoRepository $procesoRepository)
    {
        $this->procesoRepository = $procesoRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(Proceso::class)->allowedFilters([
            AllowedFilter::exact('empresa_id'),
            AllowedFilter::exact('sede_id'),
            AllowedFilter::exact('informacion_empresa_id'),
        ])->allowedIncludes([
            'subprocesos',
        ]);
        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proceso $proceso
     * @return \Illuminate\Http\Response
     */
    public function show(Proceso $proceso)
    {
        return QueryBuilder::for(Proceso::whereId($proceso->id))->first();
    }

    public function guardarProcesos(Request $request)
    {
        return $this->procesoRepository->guardarProcesos($request);
    }

    /**
     * Create a new Proceso instance.
     */
    // protected function store(StoreProcesoRequest $data)
    // {
    //     return $this->procesoRepository->create($data->all());
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proceso $proceso
     * @return \Illuminate\Http\Response
     */

    // public function update(UpdateProcesoRequest $request, $proceso)
    // {
    //     return $this->procesoRepository->update($request, $proceso);
    // }
}
