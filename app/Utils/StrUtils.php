<?php

namespace App\Utils;

use Illuminate\Support\Str;

class StrUtils
{
    /**
     * @param int $length
     * @return bool|string
     */
    public static function createRandomString($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    /**
     * @param $string
     * @return string
     */
    public static function cleanYouTube($string)
    {
        $string = str_replace(['http://', 'https://', 'watch?v='], '', $string);
        $string = str_replace('youtu.be', 'www.youtube.com', $string);

        if (substr($string, 0, 15) != 'www.youtube.com') {
            return '';
        }

        if (($pos = strpos($string, '&')) !== false) {
            $string = substr($string, 0, $pos);
        }

        if (($pos = strpos($string, '?')) !== false) {
            if (strpos($string, 'playlist?list') === false) {
                $string = substr($string, 0, $pos);
            }
        }

        if (($pos = strpos($string, '#')) !== false) {
            $string = substr($string, 0, $pos);
        }

        if (strpos($string, 'channel') != false) {
            $string = str_replace('embed/', '', $string);
        } else {
            if (substr($string, 16, 5) != 'embed') {
                $string = substr($string, 0, 15) . '/embed/' . substr($string, 16);
            }
        }

        return 'https://' . $string;
    }

    /**
     * @param $value
     *
     * @return string
     */
    public static function formatPhone($value)
    {
        return preg_replace(
            "/([0-9]{3})([0-9]{3})([0-9]{4})/",
            "($1) $2-$3",
            self::stripNonNumeric($value)
        );
    }

    /**
     * @param $string
     *
     * @return string
     */
    public static function stripNonNumeric($string)
    {
        return preg_replace("/[^0-9]/", "", $string);
    }

    /**
     * @param $value
     *
     * @return string
     */
    public static function convertNull($value)
    {
        return ($value === null) ? '' : $value;
    }

    /**
     * @param $value
     *
     * @return string
     */
    public static function formatName($value)
    {
        $value = Str::title(strtolower($value));

        if (! preg_match_all(
            "/(?<='|\-|(Mc))[a-z]/",
            $value,
            $matches,
            PREG_OFFSET_CAPTURE
        )) {
            return $value;
        }

        foreach ($matches[0] as [$match, $offset]) {
            $value = substr_replace(
                $value,
                strtoupper($match),
                $offset,
                1
            );
        }

        return $value;
    }

    /**
     * @param $url
     * @return string
     */
    public static function stripHTTPS($url)
    {
        return preg_replace('#(http(s)?://)?(www\.)?#', '', $url);
    }
}
