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
            'valor_huella_base' => ['required', 'integer'],
            'huella_comparativo' => ['required', 'integer'],
            'valor_huella_comparativo' => ['required', 'integer'],
            'alcances_huella' => ['required', 'string'],
            'priorizacion' => ['required', 'integer'],
            'indicador' => ['required', 'integer'],
            'verificacion_interna' => ['required', 'integer'],
            'optimizacion_procesos' => ['required', 'integer'],
            'verificacion_tercero' => ['required', 'integer'],
            'declaracion_conformidad_tercero' => ['required', 'integer'],
            'acciones_mejora' => ['required', 'integer'],
            'metas_mitigacion' => ['required', 'integer'],
            'meta_reduccion' => ['required', 'integer'],
            'anio_meta' => ['required', 'integer'],
            'anio_proyeccion_meta' => ['required', 'integer'],
            'meta_alineada' => ['required', 'integer'],
            'metodologias' => ['required', 'integer'],
            'seguimiento_cumplimiento' => ['required', 'integer'],
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
            'usuario_creacion_id' => ['required', 'integer'],
            'empresa_id' => ['required', 'integer'],
            'sede_id' => ['required', 'integer'],
        ];
    }
}