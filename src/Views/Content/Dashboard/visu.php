<a class="button" href="?controller=ControllerDashboard&action=edit" style="position: absolute; right: 0;">
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

	<?php include(__DIR__ . "/../../Plugins/visual_dashboard_constructor.php"); ?>
</div>