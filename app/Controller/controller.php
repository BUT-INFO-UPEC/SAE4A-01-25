<?php
session_start();

$action = $_GET["action"] ?? 'acceuil';

switch ($action) {
    case 'accueil':
        header("Location: ../index.php"); // redirection
        break;
    case 'signUp':
        require(__DIR__ . '/../Model/Actions/inscription.php');
    case 'signIn':
        require(__DIR__ . '/../Model/Actions/connexion.php');
    case 'profil':
        header('Location : sae/Actions/Profil.php');
    case 'crea_dasbord':
        require(__DIR__ . '/../Model/Actions/crea_dasbord.php');
    case 'search_dasbord':
        require(__DIR__ . '/../Model/Actions/search_dasbord.php');
    default:
        $_SESSION["error"] = "Action non reconnue !";
        require(__DIR__ . "/../layout/composants_balistiques_specifiques/error.php");
}
