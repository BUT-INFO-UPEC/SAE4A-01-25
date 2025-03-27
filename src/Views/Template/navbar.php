<hr>
<nav class="header-menu">
	<a href="<?= CONTROLLER_URL ?>?controller=ControllerGeneral" class="nav-link"> Accueil </a>

	<a href="<?= CONTROLLER_URL ?>?controller=ControllerDashboard&action=new_dashboard" class="nav-link"> Création </a>


	<a href="<?= CONTROLLER_URL ?>?controller=ControllerDashboard&action=browse" class="nav-link"> Liste </a>

	<?php if (isset($_SESSION['dash'])) : ?>
		<a href="<?= CONTROLLER_URL ?>?controller=ControllerDashboard&action=visu_dashboard" class="nav-link"> Visualisation </a>
	<?php endif; ?>
	<a href="<?= CONTROLLER_URL ?>?controller=ControllerGeneral&action=tuto" class="nav-link"> Tutoriel </a>
</nav>
<hr>
