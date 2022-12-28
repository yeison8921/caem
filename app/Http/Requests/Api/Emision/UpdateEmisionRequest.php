<?php

namespace App\Http\Requests\Api\Emision;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateEmisionRequest.
 */
class UpdateEmisionRequest extends FormRequest
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
            // 'tipo' => ['required', 'string'],
        ];
    }
}
