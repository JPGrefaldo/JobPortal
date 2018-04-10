<?php


namespace App\Utils;


class StrUtils
{
    /**
     * @param $string
     *
     * @return string
     */
    public static function stripNonNumeric($string)
    {
        return preg_replace("/[^0-9]/", "", $string);
    }
}