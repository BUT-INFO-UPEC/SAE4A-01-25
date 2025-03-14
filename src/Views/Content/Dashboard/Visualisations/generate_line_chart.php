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

            var ctx = document.getElementById("chart<?= $params['chartId'] ?>").getContext("2d");
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Valeurs",
                        data: values,
                        borderColor: "rgba(75, 192, 192, 1)",
                        backgroundColor: "rgba(75, 192, 192, 0.2)",
                        borderWidth: 2,
                        pointRadius: 5,
                        pointBackgroundColor: "#fff",
                        pointBorderColor: "rgba(75, 192, 192, 1)"
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
                        legend: { display: true }
                    }
                }
            });
        });
    </script>
</div>
