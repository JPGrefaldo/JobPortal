<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Instagram implements Rule
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
     * @param  string $attribute
     * @param  mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (substr($value, 0, 26) === 'https://www.instagram.com/');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'instagram must be a valid Instagram URL.';
    }
}
