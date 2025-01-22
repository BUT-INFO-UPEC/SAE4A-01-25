<div class='dashboard-card' id='comp<?= $params['chartId'] ?>'>
	<script type='text/javascript'>
		google.charts.setOnLoadCallback(function() {
			var data = google.visualization.arrayToDataTable(<?= $data ?>);
			var options = {
				title: <?= $params['titre'] ?>,
				fontName: 'Poppons'
			};
			var chart = new google.visualization.PieChart(document.getElementById('comp<?= $params['chartId'] ?>'));
			chart.draw(data, options);
		});
	</script>
</div>