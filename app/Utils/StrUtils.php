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

    public static function cleanYouTube($string)
    {
        $string = str_replace(['http://', 'https://', 'watch?v='], '', $string);
        $string = str_replace('player.vimeo.com/video/www.youtube.com', 'www.youtube.com', $string);
        $string = str_replace('youtu.be', 'www.youtube.com', $string);

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
        $value = ucwords(strtolower($value));

        if (!preg_match_all("/('|\-)[a-z]/", $value, $matches)) {
            return $value;
        }

        foreach ($matches[0] as $match) {
            $value = str_replace(
                $match,
                strtoupper($match),
                $value
            );
        }

        return $value;
    }
}
