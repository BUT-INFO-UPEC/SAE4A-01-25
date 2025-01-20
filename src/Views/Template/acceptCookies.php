<?php
if (!defined('BASE_URL')) {
  $originalPath = rtrim(dirname($_SERVER['SCRIPT_NAME'], 2), '/'); // Récupère le chemin relatif sans le dernier segmet
  define('BASE_URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $originalPath . '/'); // définir BASE_URL
}

if (!defined('CONTROLLER_URL')) {
  define('CONTROLLER_URL', BASE_URL . "web/FrontController.php"); // définire CONTROLLER_URL
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">

  <title> Acceptez les cookies </title>

  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>

<body>
  <h1>Cookies:</h1>
  
  <p>Notre site utilise des cookies pour améliorer votre expérience utilisateur, analyser le trafic et personnaliser le contenu.</p>

  <p>Les cookies sont conservés pour une durée maximale de 12 mois, sauf indication contraire.</p>

  <a class="btn" href="<?= CONTROLLER_URL ?>?action=setCookies">Accépter les cookies</a>
  <a class="btn" href="<?= CONTROLLER_URL ?>?action=refuseCookies">Refuser les cookies</a>
</body>
