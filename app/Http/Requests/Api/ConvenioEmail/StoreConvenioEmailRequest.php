<?php

namespace App\Http\Requests\Api\ConvenioEmail;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreConvenioEmailRequest.
 */
class StoreConvenioEmailRequest extends FormRequest
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
            'email' => ['required', 'string'],
            'nit' => ['required', 'string'],
            'convenio_id' => ['required', 'integer'],
            'sede_id' => ['required', 'integer'],
        ];
    }
}
