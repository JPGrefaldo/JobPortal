<?php


namespace App\Faker;

use App\Utils\StrUtils;
use Faker\Provider\Base;
use Faker\Provider\en_US\PhoneNumber;

class PhoneProvider extends PhoneNumber
{
    /**
     * @var array
     */
    protected static $tollFreeFozrmats = [
        '({{tollFreeAreaCode}}) {{exchangeCode}}-####',
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