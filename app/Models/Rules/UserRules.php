<?php


namespace App\Models\Rules;


use App\Models\User;
use App\Rules\Email;
use App\Rules\Phone;
use Illuminate\Validation\Rule;

class UserRules
{
    /**
     * @return array
     */
    public static function firstName()
    {
        return ['required', 'string', 'max:255', "regex:/^[a-z'\- ]*$/i"];
    }

    /**
     * @return array
     */
    public static function lastName()
    {
        return ['required', 'string', 'max:255', "regex:/^[a-z'\-]*$/i"];
    }

    /**
     * @return array
     */
    public static function email()
    {
        return [
            'required',
            'string',
            'max:255',
            new Email(),
            Rule::unique('users')
        ];
    }

    /**
     * @param \App\Models\User $user
     *
     * @return array
     */
    public static function emailUpdate(User $user)
    {
        $rules = self::email();

        // remove Rule::unique
        array_pop($rules);

        // add custom unique check only if the email is updated
        $rules[] = function($attribute, $value, $fail) use ($user) {
            $value = strtolower($value);

            if ($user->email === $value) {
                return true;
            }

            return (User::whereKeyNot($user->id)->whereEmail($value)->count() === 0)
                ? true
                : $fail('The email has already been taken.');
        };

        return $rules;
    }

    /**
     * @return array
     */
    public static function phone()
    {
        return ['required', 'string', new Phone()];
    }

    /**
     * @return array
     */
    public static function password()
    {
        return ['required', 'string', 'min:6'];
    }
}