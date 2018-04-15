<?php

namespace App\Http\Requests;

use App\Models\Role;
use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserSignupRequest extends FormRequest
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
            'first_name'  => 'required|string|max:255',
            'last_name'   => 'required|string|max:255',
            'email'       => 'required|string|email|max:255|unique:users',
            'password'    => 'required|string|min:6',
            'phone'       => ['required', 'string', new Phone()],
            'receive_sms' => 'sometimes|numeric',
            'type'        => ['required', 'string', Rule::in([Role::CREW, Role::PRODUCER])],
        ];
    }

    public function messages()
    {
        return [
            'type.in' => 'Invalid type.'
        ];
    }
}
