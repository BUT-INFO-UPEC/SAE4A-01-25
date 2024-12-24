<?php
require_once __DIR__ . '/../lib/Psr4AutoloaderClass.php';

use Lib\Psr4AutoloaderClass;
use App\Controller\Controller;

// Initialisation de l'autoloader
$loader = new Psr4AutoloaderClass();
$loader->register();

// Ajout des namespaces
$loader->addNamespace('App\Model\Classes', __DIR__ . '/../app/Model/Classes');
$loader->addNamespace('App\Model\Requetteurs', __DIR__ . '/../app/Model/Requetteurs');
$loader->addNamespace('App\Controller', __DIR__ . '/../app/Controller');

// Test d'instanciation de la classe Controller
$controller = new Controller();

// Vérifie si les constantes sont définies
if (!defined('MODEL_ACTION')) {
    define('MODEL_ACTION', '/../app/Model/Actions/'); // Chemin par défaut
}
if (!defined('HOME_PAGE')) {
    define('HOME_PAGE', 'index.php'); // Page d'accueil par défaut
}

// Récupération et sécurisation de l'action
$action = htmlspecialchars($_GET["action"] ?? 'accueil');

// Gestion des différentes actions
switch ($action) {
    case 'accueil':
        header("Location: /" . HOME_PAGE); // Redirection vers la page d'accueil
        exit;

    case 'signUp':
        require __DIR__ . MODEL_ACTION . 'inscription.php';
        break;

    case 'signIn':
        require __DIR__ . MODEL_ACTION . 'connexion.php';
        break;

    case 'profil':
        header('Location: /sae/Actions/Profil.php'); // Assurez-vous du chemin correct
        exit;

    case 'crea_dasbord':
        require __DIR__ . MODEL_ACTION . 'crea_dasbord.php';
        break;

    case 'liste':
        session_start(); // Démarre la session si ce n'est pas déjà fait
        if (!isset($_SESSION['stations'])) {
            $_SESSION['stations'] = Controller::getStations();
        }
        require __DIR__ . MODEL_ACTION . 'Liste_dashboards.php';
        exit;

    case 'search_dasbord':
        require __DIR__ . MODEL_ACTION . 'search_dasbord.php';
        break;

    default:
        session_start(); // Assure que la session est active pour stocker l'erreur
        $_SESSION["error"] = "Action non reconnue !";
        require __DIR__ . "/../layout/composants_balistiques_specifiques/error.php";
        break;
}
