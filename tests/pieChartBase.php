<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PieChart</title>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script type = "text/javascript">
        google.charts.load('current', {packages: ['corechart']});
        google.charts.setOnLoadCallback(drawchart);

        function drawchart () {
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours'],
                ['Work', 5],
                ['Eat', 2],
                ['Sleep', 7]
            ]);

            var options = {
                title: "heures",
                fontName: 'Poppons'
            }
            var chart1 = new google.visualization.PieChart(document.getElementById("chartDiv"));
            chart1.draw(data, options)
        }
    </script>
</head>
<body>
    <div id="chartDiv"></div>
</body>
</html>