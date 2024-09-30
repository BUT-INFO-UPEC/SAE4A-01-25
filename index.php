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
    foreach ($data['results'] as $record) {  // Assurez-vous d'utiliser 'records' au lieu de 'results'  =>  ptet que entre quickphph et wampserver c different mais moi au contraire il faut que je mette 'results' au lieu de 'records' [corentin]
        // Extraire les informations du record
        $nomStation = isset($record['fields']['nom']) ? $record['fields']['nom'] : 'Nom inconnu';
        $temperature = isset($record['fields']['t']) ? $record['fields']['t'] : 'Température inconnue';
        $pression = isset($record['fields']['pres']) ? $record['fields']['pres'] : 'Pression inconnue';
        $ventVitesse = isset($record['fields']['ff']) ? $record['fields']['ff'] : 'Vitesse du vent inconnue';
        $longitude = isset($record['fields']['longitude']) ? $record['fields']['longitude'] : 'Longitude inconnue';
        $latitude = isset($record['fields']['latitude']) ? $record['fields']['latitude'] : 'Latitude inconnue';

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
    echo 'Erreur de décodage JSON : ' . json_last_error_msg(); // Afficher le message d'erreur
}
?>