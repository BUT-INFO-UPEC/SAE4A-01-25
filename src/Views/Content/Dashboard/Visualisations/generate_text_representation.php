<div class='dashboard-card' id='comp<?= $params['chartId'] ?>'>
	<h4><?= htmlspecialchars($params['titre']) ?></h4>

	<div class="d-flex justify-content-center align-items-center h-100">
		<p id="textValue<?= $params['chartId'] ?>" class="composant_componenent"
			style="font-size: 24px; font-weight: bold; text-align: center; transition: color 0.5s;">
			Chargement...
		</p>
	</div>

	<script>
		document.addEventListener("DOMContentLoaded", function() {
			var rawData = <?= json_encode($data) ?>;
			console.log("Données reçues:", rawData);

			var totalValue = rawData["total"] !== undefined ? rawData["total"] : "Donnée indisponible";
			var textElement = document.getElementById("textValue<?= $params['chartId'] ?>");

			// Détermine la couleur en fonction de la valeur
			var color;
			if (!isNaN(totalValue)) {
				totalValue = parseFloat(totalValue);
				if (totalValue < 100) {
					color = "red"; // Faible valeur
				} else if (totalValue < 500) {
					color = "orange"; // Moyenne
				} else {
					color = "green"; // Valeur élevée
				}
			} else {
				color = "black"; // Valeur non numérique
			}

			textElement.innerText = totalValue;
			textElement.style.color = color;
		});
	</script>
</div>
