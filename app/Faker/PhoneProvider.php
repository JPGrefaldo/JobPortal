<?php


namespace App\Faker;

use Faker\Provider\en_US\PhoneNumber;

class PhoneProvider extends PhoneNumber
{
    /**
     * @var array
     */
    protected static $tollFreeFormats = [
        // Standard formats
        '{{tollFreeAreaCode}}-{{exchangeCode}}-####',
        '({{tollFreeAreaCode}}) {{exchangeCode}}-####',
        // '1-{{tollFreeAreaCode}}-{{exchangeCode}}-####',
        '{{tollFreeAreaCode}}.{{exchangeCode}}.####',
    ];

    /**
     * @return string
     */
    public function phoneNumber()
    {
        return $this->tollFreePhoneNumber();
    }

    /**
     * @return string
     */
    public function unformattedPhoneNumber()
    {
        return rand(100, 999) . rand(100, 999) . rand(1000, 9999);
    }
}
