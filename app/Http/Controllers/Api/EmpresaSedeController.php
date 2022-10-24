<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\EmpresaSede\StoreEmpresaSedeRequest;
use App\Http\Requests\Api\EmpresaSede\UpdateEmpresaSedeRequest;
use Illuminate\Http\Request;
use App\Models\EmpresaSede;
use App\Repositories\EmpresaSedeRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class EmpresaSedeController.
 */
class EmpresaSedeController extends Controller
{

    /**
     * @var EmpresaSedeRepository
     */
    protected $empresa_sedeSedeRepository;

    /**
     * EmpresaSedeController constructor.
     *
     * @param  EmpresaSedeRepository  $empresa_sedeSedeRepository
     */
    public function __construct(EmpresaSedeRepository $empresa_sedeSedeRepository)
    {
        $this->empresaSedeRepository = $empresa_sedeSedeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(EmpresaSede::class)->allowedFilters([
            AllowedFilter::exact('empresa_id'),
            AllowedFilter::exact('departamento_id'),
            AllowedFilter::exact('ciudad_id'),
        ])->allowedIncludes("empresa", "departamento", "ciudad");
        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmpresaSede $empresa_sede
     * @return \Illuminate\Http\Response
     */
    public function show(EmpresaSede $empresa_sede)
    {
        return QueryBuilder::for(EmpresaSede::whereId($empresa_sede->id))->allowedIncludes("empresa", "departamento", "ciudad")->first();
    }

    /**
     * Create a new empresa instance.
     */
    protected function store(StoreEmpresaSedeRequest $data)
    {
        return $this->empresaSedeRepository->create($data->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmpresaSede $empresa_sede
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateEmpresaSedeRequest $request, $empresa_sede)
    {
        return $this->empresaSedeRepository->update($request, $empresa_sede);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmpresaSede $empresa_sede
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmpresaSede $empresa_sede)
    {
        return $empresa_sede->delete();
    }

    public function crearSede($empresa_id){        
        return $this->empresaSedeRepository->formSede($id_sede='', $empresa_id);
    }
    
    public function ActualizarSede($id_sede){
        return $this->empresaSedeRepository->formSede($id_sede, $empresa_id="");
    }
}
