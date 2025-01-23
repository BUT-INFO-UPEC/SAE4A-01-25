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
     * Supprime un cookie en réglant sa date d'expiration dans le passé
     */
    public static function unSetCookie(string $cookie_name)
    {
        // Suppression du cookie côté client en réglant une expiration passée
        setcookie(
            $cookie_name,
            "",
            time() - (3600 * 24 * 7),
            "/"
        );

        // Suppression de la valeur du tableau $_COOKIE côté serveur
        unset($_COOKIE[$cookie_name]);
    }
}
