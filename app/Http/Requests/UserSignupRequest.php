<?php

namespace App\Http\Requests;

use App\Models\Role;
use App\Models\Rules\UserRules;
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
            'nickname'    => UserRules::nickname(),
            'email'       => UserRules::confirmedEmail(),
            'password'    => UserRules::confirmedPassword(),
            'phone'       => UserRules::phone(),
            'receive_sms' => 'bool',
            'type'        => ['required', 'array', Rule::in([Role::PRODUCER, Role::CREW])],
        ];
    }

    public function messages()
    {
        return [
            'type.in'          => 'Invalid type.',
            'type.required'    => 'I want to is required',
        ];
    }
}
