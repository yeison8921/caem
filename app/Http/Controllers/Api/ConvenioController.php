<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Convenio\StoreConvenioRequest;
use App\Http\Requests\Api\Convenio\UpdateConvenioRequest;
use Illuminate\Http\Request;
use App\Models\Convenio;
use App\Models\ConvenioEmail;
use App\Repositories\ConvenioRepository;
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
        $query = QueryBuilder::for(Convenio::class)
        ->allowedIncludes([
            'emails',
        ]);
        return $query->withTrashed()->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Convenio $empresa
     * @return \Illuminate\Http\Response
     */
    public function show(Convenio $convenio)
    {
        return QueryBuilder::for(Convenio::whereId($convenio->id))->allowedIncludes([
            'emails',
        ])
        ->first();
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
        $this->convenioRepository->update($request, $convenio);
    }

    public function formConvenio($id_convenio=''){
        return $this->convenioRepository->formConvenio($id_convenio);
    }

    public function agregarCorreosConvenio(Request $request)
    {
        return $this->convenioRepository->agregarCorreosConvenio($request);
    }
    
    public function verificarEmailConvenio(Request $request)
    {
        return $this->convenioRepository->verificarEmailConvenio($request);
    }
        
    public function verificarCodigoConvenio(Request $request)
    {
        return $this->convenioRepository->verificarCodigoConvenio($request);
    }
    
    public function eliminarCorreo($id_convenio_email)
    {
        return $this->convenioRepository->eliminarCorreo($id_convenio_email);
    }
    
    public function cambiarEstadoConvenio(Request $request){
        return $this->convenioRepository->cambiarEstadoConvenio($request);
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\User  $user
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(UpdateRegistrationRequest $request, User $user)
    // {
    //     $this->userRepository->update($user, $request->all());

    //     return $user->fresh();
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\User  $user
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(User $user)
    // {
    //     return $user->delete();
    // }
}
