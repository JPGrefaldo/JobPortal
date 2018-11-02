<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Tumblr implements Rule
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
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (! $value) {
            return false;
        }

        $url = parse_url($value);

        if (preg_match('/\.tumblr\.com$/', $url['host'])) {
            return true;
        }

        return with(new TLDR())->passes($attribute, $url['host']);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'tumblr must be a valid Tumblr URL.';
    }
}
