<?php

namespace Src\Config;

class ConfAPP
{
    public static $tCookies;

    // Méthode statique pour initialiser la valeur de $tCookies
    public static function init()
    {
        self::$tCookies = time() + 3600 * 24 * 7;
    }
}
