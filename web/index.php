<?php
require_once __DIR__ . '/../lib/Psr4AutoloaderClass.php';  // Inclure le fichier Psr4AutoloaderClass.php

use Lib\Psr4AutoloaderClass;

session_start();

// Initialisation de l'autoloader
$loader = new Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('app\Models', __DIR__ . '/../app/Models');



$action = $_GET["action"] ?? 'acceuil';


switch ($action) {
    case 'accueil':
        header("Location: /" . HOME_PAGE); // redirection
        break;
    case 'signUp':
        require(__DIR__ . MODEL_ACTION . 'inscription.php');
    case 'signIn':
        require(__DIR__ . MODEL_ACTION . 'connexion.php');
    case 'profil':
        header('Location : sae/Actions/Profil.php');
    case 'crea_dasbord':
        require(__DIR__ . MODEL_ACTION . '/crea_dasbord.php');
    case 'search_dasbord':
        require(__DIR__ . MODEL_ACTION . '/search_dasbord.php');
    default:
        $_SESSION["error"] = "Action non reconnue !";
        require(__DIR__ . "/../layout/composants_balistiques_specifiques/error.php");
}
