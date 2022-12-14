<?php

namespace App\Http\Requests\Api\Empresa;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateEmpresaRequest.
 */
class UpdateEmpresaRequest extends FormRequest
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
            'nit' => ['required', 'string'],
            'telefono' => ['required', 'string'],
            'codigo_ciiu_id' => ['required', 'integer'],
            'sector_id' => ['required', 'integer'],
            'empleado_id' => ['required', 'integer'],
            'tamano_id' => ['required', 'integer'],
        ];
    }
}
