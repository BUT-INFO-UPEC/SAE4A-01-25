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
$pieChart = generatePieChart(1, json_encode($pieChartData), []);
$barChart = generateBarChart(2, json_encode($barChartData));
$lineChart = generateLineChart(3, json_encode($lineChartData));
$geoChart = generateGeoChart(4, json_encode($geoChartData));

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test des Représentations Météorologiques</title>
</head>
<body>
    <h1>Test des Représentations Météorologiques</h1>
    
    <h2>Graphique Circulaire</h2>
    <?php echo $pieChart; ?>
    
    <h2>Histogramme</h2>
    <?php echo $barChart; ?>
    
    <h2>Courbe</h2>
    <?php echo $lineChart; ?>
    
    <h2>Carte Géographique</h2>
    <?php echo $geoChart; ?>
</body>
</html>
