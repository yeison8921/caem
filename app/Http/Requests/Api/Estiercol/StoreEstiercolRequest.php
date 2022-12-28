<?php

namespace App\Http\Requests\Api\Estiercol;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreEstiercolRequest.
 */
class StoreEstiercolRequest extends FormRequest
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
            'factor_emision_ch4' => ['required', 'numeric'],
            'unidad_factor_emision_ch4' => ['required', 'string'],
            'incertidumbre_ch4_1' => ['required', 'numeric'],
            'incertidumbre_ch4_2' => ['required', 'numeric'],
            'fuente_bibliografica_ch4' => ['required', 'string'],
            'factor_emision_n2o' => ['required', 'numeric'],
            'unidad_factor_emision_n2o' => ['required', 'string'],
            'incertidumbre_n2o_1' => ['required', 'numeric'],
            'incertidumbre_n2o_2' => ['required', 'numeric'],
            'fuente_bibliografica_n2o' => ['required', 'string'],
            'tipo' => ['required', 'string'],
        ];
    }
}
