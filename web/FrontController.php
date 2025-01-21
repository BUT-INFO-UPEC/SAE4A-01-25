<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Src\Config\ConfAPP;
use Src\Controllers\ControllerDashboard;
use Src\Controllers\ControllerGeneral;


// DEFINITION DES CHEMINS
$originalPath = rtrim(dirname($_SERVER['SCRIPT_NAME'], 2), '/'); // Récupère le chemin relatif sans le dernier segmet
define('BASE_URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $originalPath . '/'); // définir BASE_URL

define('CONTROLLER_URL', BASE_URL . "web/FrontController.php"); // définire CONTROLLER_URL

// On recupère l'action passés dans l'URL ou on définit l'action par défaut
$action = $_GET["action"] ?? "default";

// actions spéciales pour l'accéptation des cookies
if ($action == 'setCookies') {
  setcookie("acceptationCookies", True, ConfAPP::$tCookies);
  $_COOKIE['acceptationCookies'] = True;
  $action = "default";
}
if ($action == 'refuseCookies') {
  setcookie("acceptationCookies", False, ConfAPP::$tCookies);
  $_COOKIE['acceptationCookies'] = False;
  $action = "default";
}

// Vérification de l'accépatation des cookies et lancement de l'action
if (isset($_COOKIE['acceptationCookies'])) {
  if ($_COOKIE['acceptationCookies']) {
    // Comme le fichier est une etape obligée (rte d'entrée), on initialise la session (pour etre sur que c fait)
    session_start();

    // On recupère le controleur
    $defaultController = $_COOKIE["CurrentContoller"] ?? "ControllerGeneral"; // Vérifier si l'utilisateur a déja été sur le site, si oui, il retourne sur ce qu'il etait en train de faire, sinon, page d'accueil
    $controller = $_GET["controller"] ?? $defaultController; // On vérifie si l'utilisateur se dirige vers un autre controleur spéxifié, sion on le mets sur celui décidé précédament

    setcookie("CurrentContoller", $controller, time() + 3600); // On enregistre le cookie du controleur sur lequel travail l'utilisateur
    $_COOKIE["CurrentContoller"] = $controller; //ajout manuel pour utilisation immédiate


    // Extraire la partie du contrôleur apres'Controller' pour définir le model avec lequel on travail
    $_SESSION['controller'] = substr($controller, 10);

    // Ajouter le namespace au contrôleur
    $controller = "Src\\Controllers\\" . $controller;

    // echo $controller . "::" . $action . "() <br>";

    // Vérification de l'existence de la classe
    if (class_exists($controller)) {
      // Vérification de l'existence de la méthode
      if (method_exists($controller, $action)) {
        // Appel de la méthode statique $action du controleur actif
        $controller::$action();
      } else {
        $error = "Erreur: La méthode $action du controller '$controller' n'existe pas.";
        require __DIR__ . '/../src/Views/Plugins/composants_balistiques_specifiques/error.php';
      }
    } else {
      $error = "Erreur: Le controller '$controller' n'existe pas.";
      require __DIR__ . '/../src/Views/Plugins/composants_balistiques_specifiques/error.php';
    }
  } else {
    require('../src/Views/Template/cookiesRefused.php');
  }
} else {
  require('../src/Views/Template/acceptCookies.php');
}
