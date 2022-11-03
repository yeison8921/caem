<?php

namespace App\Http\Requests\Api\UserRegister;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class StoreRegisterRequest.
 */
class updateRegisterRequest extends FormRequest
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
            'first_name' => ['sometimes', 'string', 'max:100'],
            'email' => ['sometimes', 'string', 'email', 'max:255'],
            'password' => ['sometimes', 'string', 'max:100'],
            'estado' => ['nullable', 'integer'],
        ];
    }
}
