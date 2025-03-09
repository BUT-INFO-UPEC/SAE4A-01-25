<a class="button" href="?action=edit" style="position: absolute; right: 0;">
	modifier
</a>

<h1 class="centered"> <?= $dash->get_name(); ?> </h1>

<div class="container">
	<h3 class="centered"> Stations analysées </h3>

	<hr />

	<div class="flex">
		<div class="container">
			<h3> Zone(s) géographique(s) </h3>

			<?php
			foreach ($dash->get_region() as $key => $values) {
				echo "<p> <b> $key </b> : " . implode(", ", $values) . "<p>";
			}
			?>
		</div>

		<div class="container">
			<h3 style="flex-grow: 1"> Periode temporelle </h3>

			<p> début : <span class="<?= $dash->dateDebutRelatif ? 'date_dynamique' : '' ?>"><?= $dash->get_date_relative() ?> <?= $dash->dateDebutRelatif ? ' (relative)' : '' ?></span></p>

			<p> fin : <span class="<?= $dash->dateFinRelatif ? 'date_dynamique' : '' ?>"><?= $dash->get_date_relative('fin') ?><?= $dash->dateFinRelatif ? ' (relative)' : '' ?></span></p>
		</div>
	</div>
</div>

<?php if ($dash->get_comment() != null) { ?>
	<div class="container">
		<h3> Commentaires </h3>

		<?= $dash->get_comment(); ?>
	</div>
<?php } ?>

<div class="container centered">
	<h3> Visualisation du dashboard </h3>

	<hr />

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	<script>
		google.charts.load('current', {
			packages: ['corechart']
		});
	</script>

	<div id='dashboard'>
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
</div>
