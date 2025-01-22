<?php

namespace Src\Config;

use Directory;

class ConfAPP
{
    // Durée des cookies (7 jours)
    public static function setCookie(string $ccokie_name, $cookie_value)
    {
        setcookie(
            $ccokie_name,
            $cookie_value,
            time() + 3600 * 24 * 7,
            "/",
        );
    }
}
