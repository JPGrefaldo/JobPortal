<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Facebook implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (substr($value, 0, 25) === 'https://www.facebook.com/');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'facebook must be a valid Facebook URL.';
    }
}
