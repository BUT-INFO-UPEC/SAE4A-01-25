<?php

namespace Src\Config;

class ConfAPP
{
    // Durée des cookies (7 jours)
    public static function setCookie(string $ccokie_name, $cookie_value)
    {
        setcookie(
            $ccokie_name,
            $cookie_value,
            time() + (3600 * 24 * 7),
            "/",
        );
    }

    /**
     * unSetCookie() :
     * Supprime un cookie
     */
    public static function unSetCookie(string $cookie_name)
    {
        setcookie(
            $cookie_name,
            "",
            time() + (3600 * 24 * 7)
        );
    }
}
