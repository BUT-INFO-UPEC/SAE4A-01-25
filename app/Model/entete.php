<?php

namespace App\Model;

require_once __DIR__ . "/../Model/classes/Dashboard.php";
if (!isset($_SESSION)) {
    session_start();
}

class Entete
{

    /**
     * Retourne l'ID de l'utilisateur si il  est connécté, sinon 0
     * 
     * @return int l'ID du compte de l'utilisateur
     */
    public static function get_session_user_id()
    {
        return $_SESSION['user_id'] ?? 0;
    }
    public static function out($str)
    {
        // Si $str est un tableau, on utilise print_r() pour l'afficher
        if (is_array($str)) {
            echo "<p>" . json_encode($str) . "</p>";
        } else {
            echo "<p>$str</p>";
        }
    }
}
