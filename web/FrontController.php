<?php
require_once __DIR__ . "/../src/Controllers/ControllerGeneral.php";

// On recupère l'action passés dans l'URL ou on définit l'action par défaut
$action = $_GET["action"] ?? "default";

if ($action == 'setCookies') {
  setcookie("acceptationCookies", True, time() + 3600 * 24 * 7);
  $_COOKIE['acceptationCookies'] = True;
  $action = "default";
}
if ($action == 'refuseCookies') {
  setcookie("acceptationCookies", False, time() + 3600 * 24 * 7);
  $_COOKIE['acceptationCookies'] = False;
  $action = "default";
}

if (isset($_COOKIE['acceptationCookies'])) {
  if ($_COOKIE['acceptationCookies']) {
    // Comme le fichier est une etape obligée, on initialise la session
    session_start();
  
  
    // On recupère le controleur
    $defaultController = $_COOKIE["CurrentContoller"] ?? "ControllerGeneral"; // Vérifier si l'utilisateur a déja été sur le site, si oui, il retourne sur ce qu'il etait en train de faire, sinon, page d'accueil
    $controller = $_GET["controller"] ?? $defaultController; // On vérifie si l'utilisateur se dirige vers un autre controleur spéxifié, sion on le mets sur celui décidé précédament
  
    setcookie("CurrentContoller", $controller, time() + 3600); // On enregistre le cookie du controleur sur lequel travail l'utilisateur
    $_COOKIE["CurrentContoller"] = $controller; //ajout manuel pour utilisation immédiate
  
  
    // Extraire la partie du contrôleur apres'Controller' pour définir le model avec lequel on travail
    $_SESSION['controller'] = substr($controller, 10);
  
    // Appel de la méthode statique $action du controleur actif
    $controller::$action();
  } else {
    require('../src/Views/Template/cookiesRefused.php');
  }
} else {
  require('../src/Views/Template/acceptCookies.php');
}
