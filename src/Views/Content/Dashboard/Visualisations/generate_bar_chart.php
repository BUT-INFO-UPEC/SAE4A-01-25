<div class='dashboard-card' id='comp<?= $params['chartId'] ?>'>
	<?php
	?>

	<script type='text/javascript'>
		window.onload = function() {
			setTimeout(function() {
				google.charts.setOnLoadCallback(function() {
					var rawData = <?= json_encode($data) ?>;
					console.log("Données envoyées à Google Charts:", rawData);
					var data = google.visualization.arrayToDataTable(rawData);
					console.log("Données interprétées par Google Charts:", data);

					var options = {
						title: <?= json_encode($params['titre']) ?>,
						hAxis: {
							title: <?= json_encode($params['hAxisTitle'] ?? 'Catégories') ?>
						},
						vAxis: {
							title: <?= json_encode($params['vAxisTitle'] ?? 'Valeurs') ?>
						},
						legend: {
							position: 'none'
						},
						fontName: 'Poppons'
					};

					var chart = new google.visualization.BarChart(document.getElementById('comp<?= $params['chartId'] ?>'));

					console.log(options);

					chart.draw(data, options);
				});
			}, 1000); // Attendre un peu pour s'assurer que la taille est correcte
		}
	</script>
</div>