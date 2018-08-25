<?php

namespace App\Http\Requests\Account;

use App\Models\Rules\UserRules;
use Illuminate\Foundation\Http\FormRequest;

class AccountPasswordRequest extends FormRequest
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
            'current_password'  => UserRules::currentPassword(),
            'password'          => UserRules::confirmedPassword(),
        ];
    }
}
