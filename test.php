<?php
// URL de l'API
$apiUrl = 'https://public.opendatasoft.com/api/explore/v2.1/catalog/datasets/donnees-synop-essentielles-omm/records';

// Initialiser une session cURL
$ch = curl_init();

// Configurer les options de cURL
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Désactiver la vérification SSL pour le test

$response = curl_exec($ch);

// Vérifier si une erreur s'est produite
if (curl_errno($ch)) {
    echo 'Erreur cURL: ' . curl_error($ch);
    curl_close($ch);
    exit;
}

// Fermer la session cURL
curl_close($ch);

// Décoder les données JSON
$data = json_decode($response, true);

// Vérifier si les données sont valides
if (json_last_error() === JSON_ERROR_NONE) {
    echo '<h1>Données météorologiques</h1>';
    echo '<ul>';

    // Parcourir les résultats
    foreach ($data['results'] as $record) {
        // Extraire les informations du record
        $nomStation = isset($record['nom']) ? $record['nom'] : 'Nom inconnu';
        $temperature = isset($record['t']) ? $record['t'] : 'Température inconnue';
        $pression = isset($record['pres']) ? $record['pres'] : 'Pression inconnue';
        $ventVitesse = isset($record['ff']) ? $record['ff'] : 'Vitesse du vent inconnue';
        $longitude = isset($record['longitude']) ? $record['longitude'] : 'Longitude inconnue';
        $latitude = isset($record['latitude']) ? $record['latitude'] : 'Latitude inconnue';

        echo '<li>';
        echo 'Station : ' . htmlspecialchars($nomStation) . '<br>';
        echo 'Température : ' . htmlspecialchars($temperature) . ' K<br>';
        echo 'Pression : ' . htmlspecialchars($pression) . ' hPa<br>';
        echo 'Vitesse du vent : ' . htmlspecialchars($ventVitesse) . ' m/s<br>';
        echo 'Coordonnées : (' . htmlspecialchars($latitude) . ', ' . htmlspecialchars($longitude) . ')<br>';
        echo '</li>';
    }

    echo '</ul>';
} else {
    echo 'Erreur de décodage JSON.';
}

