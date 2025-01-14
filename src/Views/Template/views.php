<?php
if (!defined('BASE_URL')) {
  $originalPath = rtrim(dirname($_SERVER['SCRIPT_NAME'], 2), '/'); // Récupère le chemin relatif sans le dernier segmet
  define('BASE_URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $originalPath . '/'); // définir BASE_URL
}

if (!defined('CONTROLLER_URL')) {
  define('CONTROLLER_URL', BASE_URL . "web/FrontController.php"); // définire CONTROLLER_URL
}

$controller = $_SESSION['controller']
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">

  <title><?= $titrePage; ?></title>

  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>

<body>
  <?php require __DIR__ . "/header.php"; ?>

  <div class="container">
    <aside>
      <?php require __DIR__ . "/sidebar.php"; ?>
    </aside>

    <main>
      <?php require __DIR__ . "/../Content/$controller/$cheminVueBody"; ?>
    </main>
  </div>

  <?php require __DIR__ . "/footer.php"; ?>
</body>

</html>
