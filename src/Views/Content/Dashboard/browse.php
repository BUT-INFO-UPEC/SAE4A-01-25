<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style_filtre.css">

<!-- Interface utilisateur pour les filtres -->
<form method="GET" class="filters">
	<label for="region">Filtrer par région :</label>
	<select name="region" id="region">
		<option value="">Toutes les régions</option>
		<!-- Liste des régions -->
		<option value="1" <?= $region === '1' ? 'selected' : '' ?>>Guadeloupe</option>
		<option value="2" <?= $region === '2' ? 'selected' : '' ?>>Martinique</option>
		<option value="3" <?= $region === '3' ? 'selected' : '' ?>>Guyane</option>
		<option value="4" <?= $region === '4' ? 'selected' : '' ?>>La Réunion</option>
		<option value="6" <?= $region === '6' ? 'selected' : '' ?>>Mayotte</option>
		<option value="11" <?= $region === '11' ? 'selected' : '' ?>>Île-de-France</option>
		<option value="24" <?= $region === '24' ? 'selected' : '' ?>>Centre-Val de Loire</option>
		<option value="27" <?= $region === '27' ? 'selected' : '' ?>>Bourgogne-Franche-Comté</option>
		<option value="28" <?= $region === '28' ? 'selected' : '' ?>>Normandie</option>
		<option value="32" <?= $region === '32' ? 'selected' : '' ?>>Hauts-de-France</option>
		<option value="44" <?= $region === '44' ? 'selected' : '' ?>>Grand Est</option>
		<option value="52" <?= $region === '52' ? 'selected' : '' ?>>Pays de la Loire</option>
		<option value="53" <?= $region === '53' ? 'selected' : '' ?>>Bretagne</option>
		<option value="75" <?= $region === '75' ? 'selected' : '' ?>>Nouvelle-Aquitaine</option>
		<option value="76" <?= $region === '76' ? 'selected' : '' ?>>Occitanie</option>
		<option value="84" <?= $region === '84' ? 'selected' : '' ?>>Auvergne-Rhône-Alpes</option>
		<option value="93" <?= $region === '93' ? 'selected' : '' ?>>Provence-Alpes-Côte d'Azur</option>
		<option value="94" <?= $region === '94' ? 'selected' : '' ?>>Corse</option>
	</select>

	<label for="order">Trier par :</label>
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