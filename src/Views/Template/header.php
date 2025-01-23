<header>

	<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style_layout.css">

	<div class="header-container">
		<!-- Titre centré -->
		<div class="titre-header">
			<img src="<?= BASE_URL . 'assets/img/logosite.jpg'; ?>" alt="Logo du Site" class="me-2"
				style="width: 80px; height: 80px;">
		</div>

		<?php require __DIR__ . "/navbar.php"; ?>

		<!-- Icône alignée à droite -->
		<?php include __DIR__ . "/icon_account.php"; ?>
	</div>

</header>