<?php

/**
 * @param $string
 *
 * @return string
 */
function stripNonNumeric($string)
{
    return preg_replace("/[^0-9]/", "", $string);
}
