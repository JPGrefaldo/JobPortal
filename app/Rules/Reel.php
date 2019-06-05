<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Reel implements Rule
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
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (with(new YouTube())->passes($attribute, $value)
            || with(new Vimeo())->passes($attribute, $value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The reel must be a valid Reel.';
    }
}
