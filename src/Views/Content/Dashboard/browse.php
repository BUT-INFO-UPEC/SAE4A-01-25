<!--Ajout d'un style simple efficasse pour le filtrage-->

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

	.filters {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    align-items: center; /* Aligne les éléments verticalement */
    background: #f8f8f8;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
	}

	.filters label {
    font-weight: bold;
    margin-right: 10px;
	}

	.filters input[type="date"],
	.filters select {
    flex: 1; /* Permet aux éléments d’avoir une taille proportionnelle */
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: auto; /* Empêche le champ de date de s'étendre trop */
	}

	#custom-dates {
    display: flex;
    gap: 15px;
    align-items: center;
	}

	button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 8px 12px;
    font-size: 14px;
    border-radius: 5px;
    cursor: pointer;
    width: auto; /* Évite l'étirement */
	}

	button:hover {
    background-color: #0056b3;
	}


    .list-dash {
        list-style-type: none;
        padding: 0;
    }

    .list-dash .card {
        background: #fff;
        padding: 15px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
    }

    .list-dash .card:hover {
        transform: scale(1.02);
        box-shadow: 3px 3px 6px rgba(0, 0, 0, 0.15);
    }

    .list-dash .card-body {
        text-decoration: none;
        color: #333;
        font-size: 16px;
    }

    .list-dash .card-body:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .filters {
            flex-direction: column;
            gap: 10px;
        }
    }
</style>
<!-- Interface utilisateur pour les filtres -->
<form method="GET" class="filters">
	<label for="region">Filtrer par région :</label>
	<select name="region" id="region">
		<option value="">Toutes les régions</option>
		<!-- Remplacer les options ci-dessous par des valeurs dynamiques -->
		<option value="Region1" <?= $region === 'Region1' ? 'selected' : '' ?>>Région 1</option>
		<option value="Region2" <?= $region === 'Region2' ? 'selected' : '' ?>>Région 2</option>
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

	<div id="custom-dates" style="display: <?= $dateFilter === 'custom' ? 'block' : 'none' ?>;">
		<label for="start_date">Date de début :</label>
		<input type="date" name="start_date" id="start_date" value="<?= htmlspecialchars($customStartDate) ?>">

		<label for="end_date">Date de fin :</label>
		<input type="date" name="end_date" id="end_date" value="<?= htmlspecialchars($customEndDate) ?>">
	</div>

	<button type="submit">Appliquer</button>
</form>

<!-- Liste des tableaux de bord filtrés -->
<ul class="list-dash">
	<?php foreach ($filteredDashboards as $dash) : ?>
		<?php $lien = CONTROLLER_URL . "?action=visu_dashboard&dashId=" . $dash->get_id(); ?>
		<li class="card">
			<a href="<?= $lien ?>" class="card-body">
				<?= htmlspecialchars($dash->get_name()) ?>
			</a>
		</li>
	<?php endforeach; ?>
</ul>

<script>
	// Affichage conditionnel des champs de date personnalisés
	const dateSelect = document.getElementById('date');
	const customDates = document.getElementById('custom-dates');
	dateSelect.addEventListener('change', function() {
		customDates.style.display = this.value === 'custom' ? 'block' : 'none';
	});
</script>