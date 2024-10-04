<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
</script>

<?php
function CSVarray($data, $entete) {
    // Initialiser le tableau avec les étiquettes des colonnes
    $formattedData = [$entete];
    
    // Ajouter chaque entrée du dictionnaire au tableau
    foreach ($data as $task => $hours) {
        $formattedData[] = [$task, $hours];
    }
    
    // Retourner les données sous forme de JSON pour utilisation avec Google Charts
    return json_encode($formattedData);
}

// Générer une visualisation de type 'chart' avec les données injectéses
function generatePieChart($compId, $data, $paramsAffich) {
    $chartId = 'comp' . $compId;
    return "
    <div id='$chartId'></div>
    <script type='text/javascript'>
        google.charts.setOnLoadCallback(function() {
            var data = google.visualization.arrayToDataTable($data);
            var options = " . json_encode($paramsAffich) . ";
            var chart = new google.visualization.PieChart(document.getElementById('$chartId'));
            chart.draw(data, options);
        });
    </script>";
}

function generateGeoChart($compId, $data) {
    $chartId = 'comp' . $compId;
    
    return "
    <div id='$chartId'></div>
    <script type='text/javascript'>
        google.charts.load('current', {'packages':['geochart']});
        google.charts.setOnLoadCallback(function() {
            var data = google.visualization.arrayToDataTable($data);
            var options = {
                region: 'world', // Limiter la zone (par exemple : 'US' pour USA)
                displayMode: 'regions',
                colorAxis: {colors: ['#e7711c', '#4374e0']}
            };
            var chart = new google.visualization.GeoChart(document.getElementById('$chartId'));
            chart.draw(data, options);
        });
    </script>";
}

function generateLineChart($compId, $data) {
    $chartId = 'comp' . $compId;
    
    return "
    <div id='$chartId'></div>
    <script type='text/javascript'>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(function() {
            var data = google.visualization.arrayToDataTable($data);
            var options = {
                title: 'Line Chart Example',
                curveType: 'function',
                legend: { position: 'bottom' }
            };
            var chart = new google.visualization.LineChart(document.getElementById('$chartId'));
            chart.draw(data, options);
        });
    </script>";
}

function generateBarChart($compId, $data) {
    $chartId = 'comp' . $compId;
    
    return "
    <div id='$chartId'></div>
    <script type='text/javascript'>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(function() {
            var data = google.visualization.arrayToDataTable($data);
            var options = {
                title: 'Histogram Example',
                hAxis: {title: 'Category'},
                vAxis: {title: 'Value'},
                legend: { position: 'none' }
            };
            var chart = new google.visualization.Histogram(document.getElementById('$chartId'));
            chart.draw(data, options);
        });
    </script>";
}

?>