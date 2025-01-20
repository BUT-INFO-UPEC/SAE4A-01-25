<?php
$controller = $_SESSION['controller']
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">

  <title><?= $titrePage; ?></title>

  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style_layout.css">
  <!-- jQuery, Popper.js, et Bootstrap JS (nécessaires pour le modal Bootstrap) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap JS (inclut Popper.js) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <?php require __DIR__ . "/header.php"; ?>

  <div class="flex">
    <?php require __DIR__ . "/sidebar.php"; ?>

    <main>
      <?php require __DIR__ . "/../Content/$controller/$cheminVueBody"; ?>
    </main>
  </div>

  <?php require __DIR__ . "/footer.php"; ?>

  <style>
    main {
      width: 100%;
      margin: 1%;
      padding: 1%;
      /**
      * bordures
       */
      border: 1px solid #000;
      border-radius: 15px
    }
  </style>
</body>

</html>