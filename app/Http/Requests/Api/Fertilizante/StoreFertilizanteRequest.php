<?php

namespace App\Http\Requests\Api\Fertilizante;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreFertilizanteRequest.
 */
class StoreFertilizanteRequest extends FormRequest
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
            'tipo' => ['required', 'string'],
        ];
    }
}
