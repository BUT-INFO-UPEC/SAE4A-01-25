<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
	google.charts.load('current', {
		packages: ['corechart']
	});
</script>

<div id='dashboard' class="d-flex flex-wrap gap-4">
	<?php
	foreach ($dash->get_composants() as $composant) { // parcourir les composants
		// récupérer les données de paramétrage et de visualisation
		$visualisation_file = $composant->get_visu_file();
		$data = $composant->get_data($dash); // construit les données en fesant une requette a l'API dans la classe composant
		// var_dump($data);
		$params = $composant->get_params();
		// appeler la visualisation correspondante
		require  __DIR__ . "/Visualisations/$visualisation_file";
	}
	?>
</div>