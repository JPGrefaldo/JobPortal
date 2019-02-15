<?php

namespace App\Models\Rules;

use App\Rules\CurrentPassword;
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
        return [
            'required',
            'string',
            'max:255',
            "regex:/^[a-z'\- ]*$/i",
        ];
    }

    /**
     * @return array
     */
    public static function lastName()
    {
        return [
            'required',
            'string',
            'max:255',
            "regex:/^[a-z'\- ]*$/i",
        ];
    }

    /**
     * @return array
     */
    public static function nickname()
    {
        return [
            'nullable',
            'string',
            'max:255',
            "regex:/^[a-z'\- ]*$/i",
        ];
    }

    /**
     * @param null|int $id
     *
     * @param bool $unique
     * @return array
     */
    public static function email($id = null, $unique = true)
    {
        $defaults = [
            'required',
            'confirmed',
            'string',
            'max:255',
            new Email(),
        ];

        if ($unique) {
            return array_merge($defaults, [
                Rule::unique('users')->ignore($id),
            ]);
        }

        return $defaults;
    }

    /**
     * @param null|int $id
     *
     * @param bool $unique
     * @return array
     */
    public static function confirmedEmail($id = null, $unique = true)
    {
        return array_merge(self::email($id, $unique), [
            'confirmed',
        ]);
    }

    /**
     * @return array
     */
    public static function phone()
    {
        return [
            'required',
            'string',
            new Phone(),
        ];
    }

    /**
     * @return array
     */
    public static function password()
    {
        return [
            'required',
            'string',
            'min:6',
        ];
    }

    /**
     * @return array
     */
    public static function confirmedPassword()
    {
        return array_merge(self::password(), [
            'confirmed',
        ]);
    }

    /**
     * @return array
     */
    public static function currentPassword()
    {
        return [
            'required',
            new CurrentPassword(),
        ];
    }
}
