<?php

namespace App\Http\Requests;

use App\Models\Role;
use App\Models\Rules\UserRules;
use App\Rules\Email;
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
            'first_name'  => UserRules::firstName(),
            'last_name'   => UserRules::lastName(),
            'email'       => UserRules::email(),
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
