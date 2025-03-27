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

            var labels = Object.keys(rawData);
            var values = Object.values(rawData).map(arr => arr[0]); // Prendre la première valeur par catégorie

            // Générer des couleurs dynamiques
            var colors = labels.map((_, index) => `hsl(${index * 50}, 70%, 60%)`);

            var ctx = document.getElementById("chart<?= $params['chartId'] ?>").getContext("2d");
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Valeurs",
                        data: values,
                        backgroundColor: colors,
                        borderColor: "#ffffff",
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: { display: true, text: <?= json_encode($params['hAxisTitle'] ?? 'Catégories') ?> }
                        },
                        y: {
                            title: { display: true, text: <?= json_encode($params['vAxisTitle'] ?? 'Valeurs') ?> },
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        });
    </script>
</div>
