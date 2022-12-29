<?php

namespace App\Http\Requests\Api\InformacionEmpresa;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreInformacionEmpresaRequest.
 */
class StoreInformacionEmpresaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'datos_proveedores' => ['required', 'integer'],
            'fuentes_moviles' => ['required', 'integer'],
            'actividad_agricola' => ['required', 'integer'],
            'huella_base' => ['required', 'integer'],
            'efecto_invernadero' => ['required', 'integer'],
            'sumideros' => ['required', 'integer'],
            'informacion_mensual' => ['required', 'integer'],
            'diagrama_procesos' => ['required', 'integer'],
            'areas_sumideros' => ['required', 'integer'],
            'informacion_centralizada' => ['required', 'integer'],
            'soportes_consumos' => ['required', 'integer'],
            'informacion_anio' => ['required', 'integer'],
            'estimaciones_consumos' => ['required', 'integer'],
            'consumos_energeticos' => ['required', 'integer'],
            'sustento_metodologico' => ['required', 'integer'],
            'compartira_reporte' => ['required', 'integer'],
            'toma_decisiones' => ['required', 'integer'],
        ];
    }
}
