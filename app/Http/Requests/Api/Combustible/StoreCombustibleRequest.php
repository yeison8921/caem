<?php

namespace App\Http\Requests\Api\Combustible;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreCombustibleRequest.
 */
class StoreCombustibleRequest extends FormRequest
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
            'nombre' => ['required', 'string'],
            'unidad_consumo' => ['required', 'string'],
            'factor_emision_co2' => ['required', 'numeric'],
            'unidad_factor_emision_co2' => ['required', 'string'],
            'incertidumbre_co2_1' => ['required', 'numeric'],
            'incertidumbre_co2_2' => ['required', 'numeric'],
            'fuente_bibliografica_co2' => ['required', 'string'],
            'factor_emision_ch4g_fuente_fija' => ['required', 'numeric'],
            'factor_emision_ch4kg_fuente_fija' => ['required', 'numeric'],
            'unidad_factor_emision_ch4_fuente_fija' => ['required', 'string'],
            'incertidumbre_ch4_1_fuente_fija' => ['required', 'numeric'],
            'incertidumbre_ch4_2_fuente_fija' => ['required', 'numeric'],
            'fuente_bibliografica_ch4_fuente_fija' => ['required', 'string'],
            'factor_emision_n2og_fuente_fija' => ['required', 'numeric'],
            'factor_emision_n2okg_fuente_fija' => ['required', 'numeric'],
            'unidad_factor_emision_n2o_fuente_fija' => ['required', 'string'],
            'incertidumbre_n2o_1_fuente_fija' => ['required', 'numeric'],
            'incertidumbre_n2o_2_fuente_fija' => ['required', 'numeric'],
            'fuente_bibliografica_n2o_fuente_fija' => ['required', 'string'],
            'factor_emision_ch4g_fuente_movil' => ['required', 'numeric'],
            'factor_emision_ch4kg_fuente_movil' => ['required', 'numeric'],
            'unidad_factor_emision_ch4_fuente_movil' => ['required', 'string'],
            'incertidumbre_ch4_1_fuente_movil' => ['required', 'numeric'],
            'incertidumbre_ch4_2_fuente_movil' => ['required', 'numeric'],
            'fuente_bibliografica_ch4_fuente_movil' => ['required', 'string'],
            'factor_emision_n2og_fuente_movil' => ['required', 'numeric'],
            'factor_emision_n2okg_fuente_movil' => ['required', 'numeric'],
            'unidad_factor_emision_n2o_fuente_movil' => ['required', 'string'],
            'incertidumbre_n2o_1_fuente_movil' => ['required', 'numeric'],
            'incertidumbre_n2o_2_fuente_movil' => ['required', 'numeric'],
            'fuente_bibliografica_n2o_fuente_movil' => ['required', 'string'],
        ];
    }
}
