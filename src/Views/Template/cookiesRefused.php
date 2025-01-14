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

  <title> Cookies refusés </title>

  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>

<body>
  <h1>Désolé, le site est actuellement inncaccéssible sans accépter les cookies.</h1>
  
  <p>Pour accéder au site, merci d'accépter les cookies : <a class="btn" href="<?= CONTROLLER_URL ?>?action=setCookies">Accépter les cookies</a></p>
</body>
