<?php
if (!defined('BASE_URL')) {
  $originalPath = rtrim(dirname($_SERVER['SCRIPT_NAME'], 2), '/'); // Récupère le chemin relatif sans le dernier segment
  define('BASE_URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $originalPath . '/'); // définir BASE_URL
}

if (!defined('CONTROLLER_URL')) {
  define('CONTROLLER_URL', BASE_URL . "web/FrontController.php"); // définir CONTROLLER_URL
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cookies refusés</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>

<body class="d-flex flex-column align-items-center justify-content-center vh-100 bg-light">
  <div class="text-center">
    <h1 class="text-danger mb-4">Désolé, le site est actuellement inaccessible sans accepter les cookies.</h1>
    <p class="lead">
      Pour accéder au site, merci d'accepter les cookies :
    </p>
    <a class="btn btn-primary btn-lg" href="?controller=ControllerGeneral&action=setCookies">Accepter les cookies</a>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>