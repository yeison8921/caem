<?php

namespace App\Http\Requests\Api\Parametro;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreEmpresaRequest.
 */
class StoreParametroRequest extends FormRequest
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
        ];
    }
}
