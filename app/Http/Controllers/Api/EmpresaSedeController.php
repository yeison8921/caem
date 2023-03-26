<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\EmpresaSede\StoreEmpresaSedeRequest;
use App\Http\Requests\Api\EmpresaSede\UpdateEmpresaSedeRequest;
use App\Models\EmpresaSede;
use App\Models\User;
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
    protected $empresaSedeRepository;

    /**
     * EmpresaSedeController constructor.
     *
     * @param  EmpresaSedeRepository  $empresaSedeRepository
     */
    public function __construct(EmpresaSedeRepository $empresaSedeRepository)
    {
        $this->empresaSedeRepository = $empresaSedeRepository;
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
            AllowedFilter::exact('direccion'),
        ])->allowedIncludes('empresa', 'departamento', 'ciudad', 'empresarios');

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
        return QueryBuilder::for(EmpresaSede::whereId($empresa_sede->id))->allowedIncludes('empresa', 'departamento', 'ciudad')->first();
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

    public function crearSede($empresa_id)
    {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN, User::TYPE_LIDER_CAEM])) {
            return $this->empresaSedeRepository->formSede($id_sede = '', $empresa_id);
        }

        return redirect()->route('welcome')->withFlashDanger(__('You do not have access to do that.'));
    }

    public function ActualizarSede($id_sede)
    {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN, User::TYPE_LIDER_CAEM])) {
            return $this->empresaSedeRepository->formSede($id_sede, $empresa_id = '');
        }

        return redirect()->route('welcome')->withFlashDanger(__('You do not have access to do that.'));
    }
}
