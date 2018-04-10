<?php


namespace App\Faker;


use App\Utils\StrUtils;
use Faker\Provider\Base;

class PhoneProvider extends Base
{
    /**
     * @return string
     */
    public function phoneNumber()
    {
        return substr(
            StrUtils::stripNonNumeric($this->generator->e164PhoneNumber),
            0,
            10
        );
    }
}