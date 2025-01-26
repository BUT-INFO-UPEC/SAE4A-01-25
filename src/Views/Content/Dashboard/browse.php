<!-- Styles améliorés -->
<style>
	.filters {
		display: flex;
		flex-wrap: wrap;
		gap: 20px;
		align-items: center;
		background: #ffffff;
		padding: 20px;
		border: 1px solid #ddd;
		border-radius: 8px;
		box-shadow: 2px 4px 8px rgba(0, 0, 0, 0.1);
		margin-bottom: 20px;
	}

	.filters label {
		font-weight: bold;
		margin-right: 10px;
	}

	.filters input[type="date"],
	.filters select {
		padding: 8px 12px;
		font-size: 14px;
		border: 1px solid #ccc;
		border-radius: 4px;
		background: #f9f9f9;
		transition: all 0.3s ease;
		min-width: 200px;
	}

	.filters select:hover,
	.filters input[type="date"]:hover {
		border-color: #007bff;
	}

	button {
		background-color: #007bff;
		color: white;
		border: none;
		padding: 10px 15px;
		font-size: 14px;
		border-radius: 5px;
		cursor: pointer;
		transition: background-color 0.3s ease;
	}

	button:hover {
		background-color: #0056b3;
	}

	#custom-dates {
		display: flex;
		gap: 15px;
		align-items: center;
		margin-top: 10px;
	}

	.list-dash {
		list-style: none;
		padding: 0;
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
		gap: 20px;
	}

	.list-dash .card {
		background: #ffffff;
		border: 1px solid #ddd;
		border-radius: 8px;
		box-shadow: 2px 4px 8px rgba(0, 0, 0, 0.1);
		overflow: hidden;
		transition: transform 0.3s ease, box-shadow 0.3s ease;
	}

	.list-dash .card:hover {
		transform: translateY(-5px);
		box-shadow: 3px 6px 12px rgba(0, 0, 0, 0.15);
	}

	.list-dash .card a {
		text-decoration: none;
		color: #333;
		display: block;
		padding: 15px;
	}

	.list-dash .card a:hover {
		color: #007bff;
	}

	/* Media Queries */
	@media (max-width: 768px) {
		.filters {
			flex-direction: column;
			align-items: stretch;
		}

		.filters label {
			margin-bottom: 5px;
		}

		.filters select,
		.filters input[type="date"],
		button {
			width: 100%;
		}

		#custom-dates {
			flex-direction: column;
			align-items: stretch;
		}
	}
</style>

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
	<?php foreach ($dashboards as $dash) : ?>
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