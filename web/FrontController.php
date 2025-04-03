<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Src\Config\CookiesConf;
use Src\Config\LogInstance;

// DEFINITION DES CHEMINS
$originalPath = rtrim(dirname($_SERVER['SCRIPT_NAME'], 2), '/'); // Récupère le chemin relatif sans le dernier segmet
define('BASE_URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $originalPath . '/'); // définir BASE_URL

define('CONTROLLER_URL', BASE_URL . "web/FrontController.php"); // définire CONTROLLER_URL

// On recupère l'action passés dans l'URL ou on définit l'action par défaut
$action = $_GET["action"] ?? "default";

// actions spéciales pour l'accéptation des cookies
if ($action == 'setCookies') {
	CookiesConf::setCookie(
		"acceptationCookies",
		True,
	);
	$_COOKIE['acceptationCookies'] = True;
	$action = "default";
}
// helloworld !
if ($action == 'refuseCookies') {
	CookiesConf::setCookie(
		"acceptationCookies",
		False,
	);
	$_COOKIE['acceptationCookies'] = False;
	$action = "default";
}

// Vérification de l'accépatation des cookies et lancement de l'action
if (isset($_COOKIE['acceptationCookies'])) {
	if ($_COOKIE['acceptationCookies']) {
		// Comme le fichier est une etape obligée (rte d'entrée), on initialise la session (pour etre sur que c fait)
		session_start();
		// echo $_SESSION['login'] ?? '';
		// On recupère le controleur
		$defaultController = "ControllerGeneral";
		$controller = $_GET["controller"] ?? $defaultController; // On vérifie si l'utilisateur se dirige vers un autre controleur spéxifié, sion on le mets sur celui décidé précédament

		// Extraire la partie du contrôleur apres'Controller' pour définir le model avec lequel on travail
		$_SESSION['controller'] = substr($controller, 10);

		// Ajouter le namespace au contrôleur
		$controller = "Src\\Controllers\\" . $controller;


		// Vérification de l'existence de la classe
		if (class_exists($controller)) {
			// Vérification de l'existence de la méthode
			if (method_exists($controller, $action)) {
				// Initialisation d'une instance de log dans la session
				$_SESSION['MSGs']["undying"][] = new LogInstance($controller . " : " . $action);

				// Appel de la méthode statique $action du controleur actif
				$controller::$action();
			} else {
				$error = "Erreur: La méthode $action du controller '$controller' n'existe pas.";
				require __DIR__ . '/error.php';
			}
		} else {
			$error = "Erreur: Le controller '$controller' n'existe pas.";
			require __DIR__ . '/error.php';
		}
	} else {
		require(__DIR__ . '/cookiesRefused.php');
	}
} else {
	require(__DIR__ . '/acceptCookies.php');
}
