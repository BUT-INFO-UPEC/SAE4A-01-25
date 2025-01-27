<?php
$controller = $_SESSION['controller'];
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title><?= $titrePage; ?></title>

	<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style_layout.css">
	<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
	<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style_navTemp.css">

	<!-- jQuery, Popper.js, et Bootstrap JS (nécessaires pour le modal Bootstrap) -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
	<script src="<?= BASE_URL ?>assets/JavaScript/formulaire.js"></script>

</head>

<body ng-app="myApp" ng-controller="myCtrl">
	<?php require __DIR__ . "/header.php"; ?>

	<div class="slim-list">
		<?php require __DIR__ . "/navTemp.php"; ?>
	</div>

	<div class="flex main-container">
		<img src="<?= BASE_URL ?>assets/img/fondaccueil.jpg" alt="Background" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: -1;">

		<?php if (isset($_SESSION['user']))  require __DIR__ . "/sidebar.php"; ?>

		<div class="w-100 m-3 glass">
			<main class="m-3">
				<?php require __DIR__ . "/message.php"; ?>
				<?php require __DIR__ . "/../Content/$controller/$cheminVueBody"; ?>
			</main>
		</div>
	</div>

	<!-- Formulaire avec rechargement automatique -->
	<?php require __DIR__ . "/Form.php"; ?>

	<?php require __DIR__ . "/footer.php"; ?>
</body>

</html>