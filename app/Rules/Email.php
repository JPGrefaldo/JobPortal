<?php

namespace App\Rules;

use Cache;
use Illuminate\Contracts\Validation\Rule;

class Email implements Rule
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
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (! filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        if (substr_count($value, '@') != 1) {
            return false;
        }

        list($box, $host) = explode('@', $value);

        if (! $this->validMXRecord($host)) {
            return false;
        }

        return true;
    }

    /**
     * Check if mx record checking is possible
     *
     * @return bool
     */
    public function canValidateMXRecord()
    {
        return function_exists('getmxrr');
    }

    /**
     * Validate if the domain has an MX record
     * This isn't perfect as some domains do not have an MX record but still accept email (though they shouldn't)
     *
     * @param string $domain
     *
     * @return bool
     */
    public function validMXRecord($domain)
    {
        if (! $this->canValidateMXRecord()) {
            return true;
        }

        return Cache::rememberForever('valid_mx_' . $domain, function () use ($domain) {
            $mxhosts = [];
            return ((getmxrr($domain, $mxhosts) == true) && ! empty($mxhosts));
        });
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid email address.';
    }
}
