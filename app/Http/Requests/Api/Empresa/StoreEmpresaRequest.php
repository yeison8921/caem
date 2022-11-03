<?php

namespace App\Http\Requests\Api\Empresa;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreEmpresaRequest.
 */
class StoreEmpresaRequest extends FormRequest
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
            'nit' => ['required', 'string'],
        ];
    }
}
