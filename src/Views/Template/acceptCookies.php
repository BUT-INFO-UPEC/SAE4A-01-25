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
  <title>Demande Cookies</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>

<body class="bg-light">
  <div class="container py-5">
    <h1 class="mb-4 text-primary">Cookies :</h1>

    <p class="lead">
      Notre site utilise des cookies pour améliorer votre expérience utilisateur, analyser le trafic et personnaliser le contenu.
    </p>

    <p class="mb-4">
      Les cookies sont conservés pour une durée maximale de 12 mois, sauf indication contraire.
    </p>

    <div class="d-flex gap-3">
      <a class="btn btn-success" href="?controller=ControllerGeneral&action=setCookies">Accepter les cookies</a>
      <a class="btn btn-danger" href="?controller=ControllerGeneral&action=refuseCookies">Refuser les cookies</a>
    </div>
  </div>

  <!-- Lien vers Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>