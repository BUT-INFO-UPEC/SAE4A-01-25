<?php
require_once '../modules_php/visualisations/googleCharts.php';

// Données statiques pour les tests
$pieChartData = [
    ['Task', 'Hours'],
    ['Work', 5],
    ['Eat', 2],
    ['Sleep', 7]
];

$barChartData = [
    ['Task', 'Hours'],
    ['Work', 5],
    ['Exercise', 1],
    ['Leisure', 3]
];

$lineChartData = [
    ['Date', 'Temperature'],
    ['2024-01-01', 5],
    ['2024-01-02', 7],
    ['2024-01-03', 6],
    ['2024-01-04', 8]
];

$geoChartData = [
    ['Country', 'Value'],
    ['France', 100],
    ['USA', 200],
    ['Brazil', 150]
];

// Générer les visualisations
$pieChart = generatePieChart(1, json_encode($pieChartData));
$barChart = generateBarChart(2, json_encode($barChartData));
$lineChart = generateLineChart(3, json_encode($lineChartData));
$geoChart = generateGeoChart(4, json_encode($geoChartData));

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Visualisation</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <header>
        Header
    </header>

    <main class="flex">
        <div class="sidebar" style="display: block; width: 6cm;">
            <p class="changing"> liste retractable de météothèques </p>
        </div>

        <div style="flex-grow: 1">
            <button class="dropdown" style="position: absolute; right: 0;">
                modifier
            </button>
            
            <h1 class="centered"> Nom météothèque </h1>

            <div class="container">

                <h3 class="centered"> Stations analysées </h3>

                <hr/>

                <div class="flex">
                    <div class="container">
                        <h3> Zone(s) géographique(s) </h3>

                        <p class="changing"> liste noms stations/ communes/ départements </p>

                        <button> Accéder a la liste des stations </button>
                    </div>

                    <div class="container">
                        <div class="flex">
                            <h3 style="flex-grow: 1"> Periode temporelle </h3>

                            <p> Météothèque <span  class="changing">statique/synamique</span> </p>
                        </div>

                        <p> début : <span  class="changing">JJ/MMAAA</span></p>

                        <p> fin : <span  class="changing">JJ/MMAAA</span></p>
                    </div>
                </div>
            </div>

            <div class="container">
                <h3> Commentaires </h3>

                <p class="changing"> Explication des analyses de la météothèque par le créateur </p>
            </div>

            <div class="container centered">
                <h3> Visualisation du dashboard </h3>

                <hr/>

                <div class="dashboard">
                    <!-- Cartes de mesures principales -->
                    <div class="dashboard-card metric1">
                        <h3>Température Max</h3>
                        <div class="metric">22°C</div>
                    </div>

                    <div class="dashboard-card metric2">
                        <h3>Température Min</h3>
                        <div class="metric">15°C</div>
                    </div>
                
                    <!-- Cartes de graphiques météo -->
                    <div class="dashboard-card chart1">
                        <h2>Carte Géographique</h2>
                        <?php echo $geoChart; ?>
                    </div>
                    <div class="dashboard-card chart2">
                        <h2>Courbe</h2>
                        <?php echo $lineChart; ?>
                    </div>
                    <div class="dashboard-card chart3">
                        <h2>Graphique Circulaire</h2>
                        <?php echo $pieChart; ?>
                    </div>
                    <div class="dashboard-card chart4">
                        <h2>Histogramme</h2>
                        <?php echo $barChart; ?>
                    </div>
                </div>            
            </div>
        </div>
    </main>

    <footer>
        Footer
    </footer>
</body>
</html>

