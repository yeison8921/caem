<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Convenio\StoreConvenioRequest;
use App\Http\Requests\Api\Convenio\UpdateConvenioRequest;
use App\Models\Convenio;
use App\Models\User;
use App\Repositories\ConvenioRepository;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class ConvenioController.
 */
class ConvenioController extends Controller
{
    /**
     * @var ConvenioRepository
     */
    protected $convenioRepository;

    /**
     * ConvenioController constructor.
     *
     * @param  ConvenioRepository  $convenioRepository
     */
    public function __construct(ConvenioRepository $convenioRepository)
    {
        $this->convenioRepository = $convenioRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(Convenio::class)->allowedFilters([
            AllowedFilter::exact('codigo'),
        ])->allowedIncludes([
            'convenio',
            'emails.sede',
        ]);

        return $query->withTrashed()->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Convenio $convenio
     * @return \Illuminate\Http\Response
     */
    public function show(Convenio $convenio)
    {
        return QueryBuilder::for(Convenio::whereId($convenio->id))->allowedIncludes([
            'emails.sede.departamento', 'emails.sede.ciudad',
        ])->first();
    }

    /**
     * Create a new convenio instance.
     */
    protected function store(StoreConvenioRequest $data)
    {
        return $this->convenioRepository->create($data->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Convenio $convenio
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateConvenioRequest $request, $convenio)
    {
        return $this->convenioRepository->update($request, $convenio);
    }

    public function formConvenio($id_convenio = '')
    {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN])) {
            return $this->convenioRepository->formConvenio($id_convenio);
        }

        return redirect()->route('welcome')->withFlashDanger(__('You do not have access to do that.'));
    }

    public function cambiarEstadoConvenio(Request $request)
    {
        return $this->convenioRepository->cambiarEstadoConvenio($request);
    }

    public function crearConvenioEmpresa(Request $request)
    {
        return $this->convenioRepository->crearConvenioEmpresa($request);
    }
}
