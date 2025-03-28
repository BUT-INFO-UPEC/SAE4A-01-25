<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style_filtre.css">

<!-- Interface utilisateur pour les filtres -->
<form method="GET" class="filters" action="?action=browse">
	<div style="height: min-content;">
		<?php require __DIR__ . "/../../Plugins/listElements.php"; ?>
	</div>

	<!-- <label for="order">Trier par :</label>
	<select name="order" id="order">
		<option value="recent" <?= $order === 'recent' ? 'selected' : '' ?>>Plus récent</option>
		<option value="most_viewed" <?= $order === 'most_viewed' ? 'selected' : '' ?>>Plus vues</option>
	</select>

	<label for="date">Filtrer par date :</label>
	<select name="date" id="date">
		<option value="today" <?= $dateFilter === 'today' ? 'selected' : '' ?>>Aujourd'hui</option>
		<option value="yesterday" <?= $dateFilter === 'yesterday' ? 'selected' : '' ?>>Hier</option>
		<option value="this_week" <?= $dateFilter === 'this_week' ? 'selected' : '' ?>>Cette semaine</option>
		<option value="custom" <?= $dateFilter === 'custom' ? 'selected' : '' ?>>Personnalisé</option>
	</select>

	<div id="custom-dates" style="display: <?= $dateFilter === 'custom' ? 'flex' : 'none' ?>;">
		<label for="start_date">Date de début :</label>
		<input type="date" name="start_date" id="start_date" value="<?= htmlspecialchars($customStartDate) ?>">

		<label for="end_date">Date de fin :</label>
		<input type="date" name="end_date" id="end_date" value="<?= htmlspecialchars($customEndDate) ?>">
	</div> -->

	<?php

	use Src\Config\Utils\SessionManagement;

	if (SessionManagement::getUser() != null) : ?>
		<select name="privatisation" id="" privatisation>
			<option value=null <?= $privatisation === null ? 'selected' : '' ?>>Tout</option>
			<option value="private" <?= $privatisation === 'private' ? 'selected' : '' ?>>Mes dashboards</option>
			<option value="public" <?= $privatisation === 'public' ? 'selected' : '' ?>>dashboards publiques</option>
		</select>
	<?php else : ?>

	<?php endif; ?>

	<div class="flex">
		<div>
			<label for="start_date">Date de début :</label>
			<input type="date" name="start_date" id="start_date" min="2016-11-05" max="<?= date("Y-m-d") ?>">
		</div>

		<div>
			<label for="end_date">Date de fin :</label>
			<input type="date" name="end_date" id="end_date" min="2016-11-05" max="<?= date("Y-m-d") ?>">
		</div>
	</div>

	<button type="submit">Appliquer</button>
</form>

<ul class="list-dash">
	<?php foreach ($dashboards as $dash): ?>
		<?php $lien = CONTROLLER_URL . "?action=visu_dashboard&dashId=" . $dash->get_id();
		$lien2 = "?action=edit&dashId=" . $dash->get_id() ?>
		<li class="card">
			<div class="dash">
				<p><?= htmlspecialchars($dash->get_name()) ?></p>
				<a href="<?= $lien ?>" class="card-body">visu</a>
				<a href="<?= $lien2 ?>" class="card-body">edit</a>
			</div>
		</li>
	<?php endforeach; ?>
</ul>
