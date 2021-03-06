<?php

namespace App\Rules;

use App\Utils\StrUtils;
use Illuminate\Contracts\Validation\Rule;

class YouTube implements Rule
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
        return (substr(StrUtils::cleanYouTube($value), 0, 24) === 'https://www.youtube.com/');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'youtube must be a valid YouTube URL.';
    }
}
