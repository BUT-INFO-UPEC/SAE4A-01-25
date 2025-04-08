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
 
            var totalValue = rawData["total"] !== undefined ? rawData["total"] : null;
            var unit = rawData["unite"] !== undefined ? rawData["unite"] : "";
 
            var textElement = document.getElementById("textValue<?= $params['chartId'] ?>");
 
            if (totalValue !== null && !isNaN(totalValue)) {
                totalValue = parseFloat(totalValue).toFixed(3) + " " + unit;
            } else {
                totalValue = "Donnée indisponible";
            }
 
            textElement.innerText = totalValue;
            textElement.style.color = "#808080";
        });
</script>
</div>