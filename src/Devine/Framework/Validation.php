<?php

// Validation.php - Class to validate strings
// By Anton Van Eechaute

namespace Devine\Framework;

class Validation
{
    static public function isMin($str, $length)
    {
        return strlen($str) >= $length ? true : false;
    }

    static public function isMax($str, $length)
    {
        return strlen($str) <= $length ? true : false;
    }

    static public function isEmail($str)
    {
        return filter_var($str, FILTER_VALIDATE_EMAIL);
    }

    static public function isAlpha($str)
    {
        return ctype_alnum($str);
    }
}
