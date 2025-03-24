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

            // Générer des couleurs dynamiques pour la ligne
            var colors = ["#ceddde", "#9cd2d5", "#8ecfd8", "#007fa9", "#00334A"]; 

            var ctx = document.getElementById("chart<?= $params['chartId'] ?>").getContext("2d");

            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: yAxisTitle,
                        data: values,
                        borderColor: "#007fa9", // Couleur de la ligne
                        backgroundColor: "rgba(0,127,169,0.2)", // Fond léger sous la ligne
                        borderWidth: 2,
                        pointBackgroundColor: colors, // Couleurs dynamiques pour les points
                        pointBorderColor: "#ffffff",
                        pointRadius: 5,
                        fill: true // Remplissage sous la courbe
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: xAxisTitle
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: yAxisTitle
                            },
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
</div>
