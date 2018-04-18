<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IMDB implements Rule
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
        return (substr($value, 0, 25) === 'http://www.imdb.com/name/');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute must be a valid IMDB URL.';
    }
}
