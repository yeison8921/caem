<?php

namespace App\Http\Requests\Api\EmpresaSede;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreEmpresaRequest.
 */
class StoreEmpresaSedeRequest extends FormRequest
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
            'empresa_id' => ['required', 'integer'],
            'departamento_id' => ['required', 'integer'],
            'ciudad_id' => ['required', 'integer'],
            'direccion' => ['required', 'string'],
        ];
    }
}
