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

            // Vérifie si les titres des axes sont présents dans les premières lignes
            var xAxisTitle = rawData[0] && rawData[0][0] ? rawData[0][0] : 'Valeur ligne 0';
            var yAxisTitle = rawData[0] && rawData[0][1] ? rawData[0][1] : 'Valeur ligne 1';

            // Extraire les labels (numer_sta) et les valeurs (Moyenne_Temperature) à partir de la ligne 1
            var labels = rawData.slice(1).map(item => item[0]);
            var values = rawData.slice(1).map(item => item[1]);

            // Couleurs dynamiques pour le pie chart
            var colors = ["#9ccad5", "#2b6777", "#8ecfd8", "#9cd2d5", "#00334A", "#ceddde", "#5b9aa0"]; 

            var ctx = document.getElementById("chart<?= $params['chartId'] ?>").getContext("2d");

            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: yAxisTitle,
                        data: values,
                        backgroundColor: colors,
                        borderColor: "#ffffff",
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    }
                }
            });
        });
    </script>
</div>
