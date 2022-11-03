<?php

namespace App\Http\Requests\Api\Convenio;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateConvenioRequest.
 */
class UpdateConvenioRequest extends FormRequest
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
            'nombre_convenio' => ['required', 'string'],
            'nombre_entidad' => ['required', 'string'],
            'codigo' => ['required', 'string'],
            'texto_legal' => ['required', 'string'],
        ];
    }
}
