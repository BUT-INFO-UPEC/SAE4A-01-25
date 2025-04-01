<div class='dashboard-card' id='comp<?= $params['chartId'] ?>'>
    <h4><?= htmlspecialchars($params['titre']) ?></h4>

    <p id="textValue<?= $params['chartId'] ?>" 
       style="font-size: 20px; text-align: center; transition: color 0.5s;">
    </p>

    </ul>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var rawData = <?= json_encode($data) ?>;
            console.log("Données reçues:", rawData);

            var totalValue = rawData["total"] !== undefined ? rawData["total"] : "Donnée indisponible";
            var textElement = document.getElementById("textValue<?= $params['chartId'] ?>");

            textElement.innerText = totalValue;
            textElement.style.color = color;
        });
    </script>
</div>
