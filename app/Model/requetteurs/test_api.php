<?php

class API
{
    // Fetch data from an API with parameters
    public function getApi(string $url, array $params)
    {
        // Add parameters to the URL
        $url .= '?' . http_build_query($params);

        // Debug: display the final URL
        echo "Final URL: " . $url . "<br>";  // This will print the final URL used for the API request

        // Initialize cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL for debugging
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        // Execute cURL request
        $response = curl_exec($ch);

        if ($response === false) {
            echo "cURL Error: " . curl_error($ch);
            curl_close($ch);
            return null;
        }

        // Decode the JSON response
        $responseData = json_decode($response, true);
        curl_close($ch);

        return $responseData;
    }
}

// API endpoint and parameters
$baseApiUrl = "https://public.opendatasoft.com/api/explore/v2.1/catalog/datasets/donnees-synop-essentielles-omm/records";
$params = [
    "order_by" => "date", // Order results by date
];

// Create an instance of the API class and fetch data
$apiInstance = new API();
$response = $apiInstance->getApi($baseApiUrl, $params);

// Prepare temperature and date arrays for the graph
$temperatures = [];
$dates = [];

// Check if the response contains the 'results' key and it is an array
if (isset($response['results']) && is_array($response['results'])) {
    // Loop through each record
    foreach ($response['results'] as $record) {
        // Accessing temperature (t) and date from each record
        $temperatureKelvin = isset($record['t']) ? $record['t'] : null; // Temperature in Kelvin
        $temperatureCelsius = ($temperatureKelvin !== null) ? $temperatureKelvin - 273.15 : null; // Convert Kelvin to Celsius

        // Add temperature to the array (formatted to 2 decimal places, if available)
        if ($temperatureCelsius !== null) {
            $temperatures[] = number_format($temperatureCelsius, 2);
        }

        // Add date to the array, format the date as needed
        if (isset($record['date'])) {
            $formattedDate = date("Y-m-d H:i:s", strtotime($record['date']));
            $dates[] = $formattedDate; // 'date' is directly inside the 'record' object
        }
    }
}

// Now $temperatures and $dates arrays are populated based on the response
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    /* Make sure the body and html take up 100% of the height */
    html,
    body {
        height: 100%;
        margin: 0;
    }

    /* Make the canvas take up 100% of the available space */
    canvas {
        width: 100% !important;
        height: 100% !important;
    }
</style>
<canvas id="temperatureChart"></canvas>
<script>
    // Data passed from PHP
    const temperatures = <?php echo json_encode($temperatures); ?>;
    const dates = <?php echo json_encode($dates); ?>;

    // Chart.js configuration
    const ctx = document.getElementById('temperatureChart').getContext('2d');
    const temperatureChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates, // X-axis labels
            datasets: [{
                label: 'Temperature (°C)',
                data: temperatures, // Y-axis data
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 1,
                tension: 0.3, // Makes the line smooth (0.3 gives a nice smooth curve)
                pointRadius: 0, // Remove points
            }]
        },
        options: {
            responsive: true, // This makes the chart responsive
            plugins: {
                legend: {
                    position: 'top',
                },
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Date'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Temperature (°C)'
                    },
                    beginAtZero: false
                }
            }
        }
    });
</script>

<?php
// Debugging the API response and the parameters
echo "<pre>";
echo "API Response:<br>";
var_dump($response);
echo "<br>API Parameters:<br>";
var_dump($params);
echo "</pre>";
?>