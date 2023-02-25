<?php

namespace App\Http\Requests\Api\InformacionEmpresa;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreInformacionEmpresaRequest.
 */
class StoreInformacionEmpresaRequest extends FormRequest
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
            // 'usuario_creacion_id' => ['required', 'integer'],
            'empresa_id' => ['required', 'integer'],
            'sede_id' => ['required', 'integer'],
        ];
    }
}
