<?php

namespace App\Rules;

use App\Actions\Social\IsVimeoPlayerUrlAction;
use App\Actions\Social\IsVimeoUrlAction;
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

        return (app(IsVimeoPlayerUrlAction::class)->execute($value) ||
            app(IsVimeoUrlAction::class)->execute($value)
        );
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
