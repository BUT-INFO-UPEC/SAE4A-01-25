<?php
$data = [
    ['Task', 'Hours per Day'],
    ['Work', 8],
    ['Eat', 2],
    ['Commute', 2],
    ['Watch TV', 4],
    ['Sleep', 8]
];

// Encodage en JSON
$data_json = json_encode($data);

// Générer le HTML pour le graphique dans une variable PHP
$chart_div = '<div id="chart_div" style="width: 900px; height: 500px;"></div>';

// Afficher le code HTML
echo $chart_div;
?>