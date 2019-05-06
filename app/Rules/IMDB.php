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
        return (bool) preg_match('/^(?:https:\/\/)?www.imdb.com\/name\/[\w]+(\/)?$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'imdb must be a valid IMDB URL.';
    }
}
