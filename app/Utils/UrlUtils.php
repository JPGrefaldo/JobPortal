<?php


namespace App\Utils;


class UrlUtils
{
    /**
     * @param string $url
     *
     * @return string
     */
    public static function getHostNameFromBaseUrl($url)
    {
        return preg_replace(
            ['/^(http(s)?:\/\/)?(www\.)?/', '/(?:\:.+)/', '/\/?$/'],
            '',
            $url
        );
    }
}
