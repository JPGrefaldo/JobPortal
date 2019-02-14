<?php

namespace App\Utils;

class FormatUtils
{
    /**
     * @param string $value
     * @return string
     */
    public static function email(string $value)
    {
        return strtolower($value);
    }

    /**
     * @param string $value
     * @return string
     */
    public static function name(string $value)
    {
        return StrUtils::formatName($value);
    }
}
