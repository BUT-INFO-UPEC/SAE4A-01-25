<div class='dashboard-card' id='comp<?= $params['chartId'] ?>'>
    <h4><?= htmlspecialchars($params['titre']) ?></h4>

    <div class="d-flex justify-content-center align-items-center h-100 p-5">
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
            var color = "grey";

            textElement.innerText = isNaN(totalValue) ? totalValue : totalValue.toFixed(3);
            textElement.style.color = color;
        });
    </script>
</div>
