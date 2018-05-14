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
     * @param null|int $id
     *
     * @return array
     */
    public static function email($id = null)
    {
        return [
            'required',
            'string',
            'max:255',
            new Email(),
            Rule::unique('users')->ignore($id)
        ];
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
