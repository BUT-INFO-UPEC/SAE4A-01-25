// Charger la bibliothèque Google Charts
import "https://www.gstatic.com/charts/loader.js";

// Fonction pour créer un graphique à partir des données et des options fournies
function createPie(chartDiv, dataList, legend) {
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(function() {
        var dataTable = google.visualization.arrayToDataTable(dataList);

        var options = {
            title: legend
        };

        var chart = new google.visualization.PieChart(chartDiv);
        chart.draw(dataTable, options);
    });
}
