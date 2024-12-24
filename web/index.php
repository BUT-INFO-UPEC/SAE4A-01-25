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


$action = $_GET["action"] ?? 'acceuil';


switch ($action) {
    case 'accueil':
        header("Location: /" . HOME_PAGE); // redirection
        break;
    case 'signUp':
        require(__DIR__ . MODEL_ACTION . 'inscription.php');
        break;
    case 'signIn':
        require(__DIR__ . MODEL_ACTION . 'connexion.php');
        break;
    case 'profil':
        header('Location: sae/Actions/Profil.php');
        break;
    case 'crea_dasbord':
        require(__DIR__ . MODEL_ACTION . '/crea_dasbord.php');
        break;
    case 'liste':
        session_start(); // Démarre la session si ce n'est pas déjà fait
        $_SESSION['stations'] = Controller::getStations();
        require(__DIR__ . MODEL_ACTION . 'Liste_dashboards.php');
        exit;
    case 'search_dasbord':
        require(__DIR__ . MODEL_ACTION . '/search_dasbord.php');
        break;
    default:
        $_SESSION["error"] = "Action non reconnue !";
        require(__DIR__ . "/../layout/composants_balistiques_specifiques/error.php");
        break;
}
