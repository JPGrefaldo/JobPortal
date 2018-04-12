<?php


namespace App\Faker;


use App\Utils\StrUtils;
use Faker\Provider\Base;
use Faker\Provider\en_US\PhoneNumber;

class PhoneProvider extends PhoneNumber
{
    protected static $tollFreeFormats = [
        '({{tollFreeAreaCode}}) {{exchangeCode}}-####'
    ];

    /**
     * @return string
     */
    public function phoneNumber()
    {
        return $this->tollFreePhoneNumber();
    }
}