<button class="dropdown" style="position: absolute; right: 0;">
	modifier
</button>

<h1 class="centered"> Nom météothèque </h1>

<div class="container">
	<h3 class="centered"> Stations analysées </h3>

	<hr />

	<div class="flex">
		<div class="container">
			<h3> Zone(s) géographique(s) </h3>

			<p class="changing"> liste noms stations/ communes/ départements </p>

			<button> Accéder a la liste des stations </button>
		</div>

		<div class="container">
			<div class="flex">
				<h3 style="flex-grow: 1"> Periode temporelle </h3>

				<p> Météothèque dynamique ? <?php echo htmlspecialchars($dash->dateFinRelatif ? 'Oui' : 'Non'); ?></p>
			</div>

			<p> début : <span class="changing">JJ/MMAAA</span></p>

			<p> fin : <span class="changing">JJ/MMAAA</span></p>
		</div>
	</div>
</div>

<div class="container">
	<h3> Commentaires </h3>

	<p class="changing"> Explication des analyses de la météothèque par le créateur </p>
</div>

<div class="container centered">
	<h3> Visualisation du dashboard </h3>

	<hr />

	<div id='dashboard'>
	<?php
	foreach ($dash->get_composants() as $composant) { // parcourir les composants
		// récupérer les données de paramétrage et de visualisation
		$visualisation_file = $composant->get_visu_file();
		$data = $composant->get_data($dash); // construit les données en fesant une requette a l'API dans la classe composant
		$params = $composant->get_params();
		// appeler la visualisation correspondante
		require  __DIR__ . "/Visualisations/$visualisation_file";
	}
	?>
	</div>
</div>