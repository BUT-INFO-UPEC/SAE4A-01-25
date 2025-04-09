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
	<?php require __DIR__ . "/Header.php"; ?>

	<?php require __DIR__ . "/Popups/navDev.php"; ?>

	<div class="flex main-container">
		<?php if (isset($_SESSION['user']))  require __DIR__ . "/Popups/Sidebar.php"; ?>

		<div class="w-100 m-3 glass">
			<main class="m-3">
				<?php require __DIR__ . "/Popups/Messages.php"; ?>
				<?php require __DIR__ . "/../Content/$controller/$cheminVueBody"; ?>
			</main>
		</div>
	</div>

	<!-- Formulaire avec rechargement automatique -->
	<?php require __DIR__ . "/Popups/User_auth_Forms.php"; ?>

	<?php require __DIR__ . "/Footer.php"; ?>
</body>

</html>