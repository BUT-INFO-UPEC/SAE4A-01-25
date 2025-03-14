<div class='dashboard-card' id='comp<?= $params['chartId'] ?>'>
    <h4><?= htmlspecialchars($params['titre']) ?></h4>

    <!-- Canvas pour le graphique -->
    <canvas id="chart<?= $params['chartId'] ?>"></canvas>

    <!-- Inclure Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var rawData = <?= json_encode($data) ?>;
            console.log("Données reçues:", rawData);

            // Extraction des labels et valeurs
            var labels = Object.keys(rawData);
            var values = Object.values(rawData).map(arr => arr[0]); // Prendre le premier élément de chaque colonne

            if (labels.includes('entier')) {
                labels = labels.filter(label => label !== 'entier'); // Ne pas afficher 'entier' comme label
                values = rawData.entier; // Utiliser entier comme valeurs si disponible
            }

            // Définir les couleurs dynamiquement
            var colors = labels.map((_, index) => `hsl(${index * 50}, 70%, 60%)`);

            // Création du graphique
            var ctx = document.getElementById("chart<?= $params['chartId'] ?>").getContext("2d");
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Répartition",
                        data: values,
                        backgroundColor: colors,
                        borderColor: "#ffffff",
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: true },
                        tooltip: { enabled: true }
                    }
                }
            });
        });
    </script>
</div>
