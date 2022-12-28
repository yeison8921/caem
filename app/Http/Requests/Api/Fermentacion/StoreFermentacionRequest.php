<?php

namespace App\Http\Requests\Api\Fermentacion;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreFermentacionRequest.
 */
class StoreFermentacionRequest extends FormRequest
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
        ];
    }
}
