<header>
	<div class="header-container">
		<!-- Titre centré -->
		<div class="titre-header">
			<!--<img src="<?= BASE_URL . 'assets/img/logosite2.png'; ?>" alt="Logo du Site" class="me-2"
				style="width: 190px; height: 50px;">-->
			<a href="<?= CONTROLLER_URL ?>?controller=ControllerGeneral" class="nav-link">
				<img src="<?= BASE_URL . 'assets/img/logosite2.png'; ?>" alt="Logo du Site" class="me-2"
					style="width: 190px; height: 50px;">
			</a> a
		</div>

		<?php require __DIR__ . "/navbar.php"; ?>

		<!-- Icône alignée à droite -->
		<?php include __DIR__ . "/icon_account.php"; ?>
	</div>
</header>