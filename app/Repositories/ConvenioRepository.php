<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Convenio;
use App\Models\ConvenioEmail;
use Illuminate\Support\Facades\DB;

/**
 * Class ConvenioRepository.
 */
class ConvenioRepository extends BaseRepository
{
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function model()
    {
        return Convenio::class;
    }

    /**
     * @param array $data
     *
     * @return Convenio
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data): Convenio
    {
        return DB::transaction(function () use ($data) {
            $convenio = Convenio::create($data);
            if ($convenio) {
                return $convenio;
            }

            throw new GeneralException(__('backend_empresas.exceptions.create_error'));
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id_convenio)
    {
        Convenio::find($id_convenio)->update($request->all());
    }

    public function agregarCorreosConvenio($request){
        foreach ($request->array_correos as $value) {
            if($value["id"] == ""){
                $convenio = new ConvenioEmail;
                $convenio->email = $value["email"];
                $convenio->nit = $value["nit"];
                $convenio->convenio_id = $request->convenio_id;
                $convenio->save();
            }
        }
    }

    public function verificarEmailConvenio($request)
    {
        $convenio = ConvenioEmail::where("email", $request->email)->first();
        return $convenio;
    }
    
    public function eliminarCorreo($id_convenio_email)
    {
        ConvenioEmail::find($id_convenio_email)->delete();
    }
    
    public function verificarCodigoConvenio($request)
    {
        $verificar_convenio = Convenio::where("codigo", $request->codigo)->first();
        if (!$verificar_convenio) {
            return response()->json("error", 500);
        }else{
            $verificar_email_convenio = ConvenioEmail::where([["email", $request->email], ["convenio_id", $verificar_convenio->id]])->first();
            if(!$verificar_email_convenio){
                return response()->json("error", 500);
            }else{
                return response()->json("success", 200);
            }
        }
    }

    public function formConvenio($id_convenio){
        $data = [];
        $data['id_convenio'] = $id_convenio;
        if($id_convenio != ''){
            $data['accion'] = 'Actualizar';
        }else{
            $data['accion'] = 'Crear';
        }
        return view('administracion/convenio/form_convenio', $data);
    }

    public function cambiarEstadoConvenio($request){
        $request->estado ? Convenio::withTrashed()->find($request->id_convenio)->restore() : Convenio::find($request->id_convenio)->delete();
    } 
}
