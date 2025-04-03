<div class='dashboard-card' id='comp<?= $params['chartId'] ?>'>
	<h4><?= htmlspecialchars($params['titre']) ?></h4>

<<<<<<< HEAD
    <p id="textValue<?= $params['chartId'] ?>" 
       style="font-size: 20px; text-align: center; transition: color 0.5s;">
    </p>

    </ul>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var rawData = <?= json_encode($data) ?>;
            console.log("Données reçues:", rawData);
=======
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
>>>>>>> d7eb33ec80fe9168d3a7c5c38aef8b745ef90a3d

			var totalValue = rawData["total"] !== undefined ? rawData["total"] : "Donnée indisponible";
			var textElement = document.getElementById("textValue<?= $params['chartId'] ?>");

<<<<<<< HEAD
            textElement.innerText = totalValue;
            textElement.style.color = color;
        });
    </script>
=======
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
>>>>>>> d7eb33ec80fe9168d3a7c5c38aef8b745ef90a3d
</div>
