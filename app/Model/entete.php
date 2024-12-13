<?php
require_once __DIR__ . "/../Model/classes/Dashboard.php";
if (!isset($_SESSION)){session_start();}

/**
 * Retourne l'ID de l'utilisateur si il  est connécté, sinon 0
 * 
 * @return int l'ID du compte de l'utilisateur
 */
function get_session_user_id() {}

function out($str) {
    // Si $str est un tableau, on utilise print_r() pour l'afficher
    if (is_array($str)) {
        echo "<p>" . json_encode($str) . "</p>";
    } else {
        echo "<p>$str</p>";
    }
}
?>