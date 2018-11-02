<?php

namespace App\Rules;

use App\Services\SocialLinksServices;
use Illuminate\Contracts\Validation\Rule;

class Vimeo implements Rule
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
        if (! $value) {
            return false;
        }

        return (SocialLinksServices::cleanVimeo($value) !== '');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'vimeo must be a valid Vimeo URL.';
    }
}
