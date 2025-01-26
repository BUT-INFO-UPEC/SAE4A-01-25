<?php
$controller = $_SESSION['controller']
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">

	<title><?= $titrePage; ?></title>


	<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style_layout.css">

	<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">


	<!-- jQuery, Popper.js, et Bootstrap JS (nécessaires pour le modal Bootstrap) -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Bootstrap JS (inclut Popper.js) -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
	<?php require __DIR__ . "/header.php"; ?>
	<?php require __DIR__ . "/Form.php"; ?>

	<div class="flex main-container">
		<?php if (isset($_SESSION['user']))  require __DIR__ . "/sidebar.php"; ?>

		<div class="w-100">
			<?php require __DIR__ . "/message.php"; ?>

			<main>
				<?php require __DIR__ . "/../Content/$controller/$cheminVueBody"; ?>
			</main>
		</div>
	</div>
	<?php require __DIR__ . "/footer.php"; ?>
</body>

</html>