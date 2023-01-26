<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ConvenioEmail\StoreConvenioEmailRequest;
use Illuminate\Http\Request;
use App\Models\ConvenioEmail;
use App\Repositories\ConvenioEmailRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class ConvenioEmailController.
 */
class ConvenioEmailController extends Controller
{

    /**
     * @var ConvenioEmailRepository
     */
    protected $convenioEmailRepository;

    /**
     * ConvenioEmailController constructor.
     *
     * @param  ConvenioEmailRepository  $empresa_sedeSedeRepository
     */
    public function __construct(ConvenioEmailRepository $convenioEmailRepository)
    {
        $this->convenioEmailRepository = $convenioEmailRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(ConvenioEmail::class)->allowedFilters([
            AllowedFilter::exact('convenio.codigo'),
            AllowedFilter::exact('convenio_id'),
            AllowedFilter::exact('email'),
        ])->allowedIncludes('convenio', 'sede', 'registrado', 'sede.empresa');
        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ConvenioEmail $convenio_email
     * @return \Illuminate\Http\Response
     */
    public function show(ConvenioEmail $convenio_email)
    {
        return QueryBuilder::for(ConvenioEmail::whereId($convenio_email->id))->allowedIncludes('convenio', 'sede', 'registrado')->first();
    }

    /**
     * Create a new empresa instance.
     */
    protected function store(StoreConvenioEmailRequest $data)
    {
        return $this->convenioEmailRepository->create($data->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ConvenioEmail $convenio_email
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConvenioEmail $convenio_email)
    {
        return $convenio_email->delete();
    }
}
