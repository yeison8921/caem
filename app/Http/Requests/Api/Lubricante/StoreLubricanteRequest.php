<?php

namespace App\Http\Requests\Api\Lubricante;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreLubricanteRequest.
 */
class StoreLubricanteRequest extends FormRequest
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
        ];
    }
}
