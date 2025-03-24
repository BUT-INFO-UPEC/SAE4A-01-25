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
            var xAxisTitle = rawData[0] && rawData[0][0] ? rawData[0][0] : 'Valeur ligne 0'; // Utilise la première valeur de la première ligne pour l'axe X
            var yAxisTitle = rawData[0] && rawData[0][1] ? rawData[0][1] : 'Valeur ligne 1'; // Utilise la deuxième valeur de la première ligne pour l'axe Y
 
            // Extraire les labels (numer_sta) et les valeurs (Moyenne_Temperature) à partir de la ligne 1
            var labels = rawData.slice(1).map(item => item[0]); // Récupère la première valeur de chaque sous-tableau à partir de la ligne 1
            var values = rawData.slice(1).map(item => item[1]); // Récupère la deuxième valeur de chaque sous-tableau à partir de la ligne 1
 
            // Générer des couleurs dynamiques pour chaque barre
            var colors = ["#ceddde", "#9cd2d5", "#8ecfd8", "#007fa9", "#00334A"]; 
 
            var ctx = document.getElementById("chart<?= $params['chartId'] ?>").getContext("2d");
 
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels, // Catégories en X
                    datasets: [{
                        label: yAxisTitle, // Utilise le titre dynamique pour l'axe Y
                        data: values, // Valeurs associées aux catégories
                        backgroundColor: colors, // Couleurs dynamiques pour chaque barre
                        borderColor: "#ffffff", // Couleur de la bordure des barres
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: xAxisTitle // Utilisation du titre dynamique pour l'axe X
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: yAxisTitle // Utilisation du titre dynamique pour l'axe Y
                            },
                            beginAtZero: true // Commence l'axe Y à 0
                        }
                    },
                    plugins: {
                        legend: {
                            display: false // Cache la légende
                        }
                    }
                }
            });
        });
    </script>
</div>
 

