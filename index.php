<?php

include "classes_php/requete.php";  // Vérifiez le chemin de ce fichier
include "database/test.php";  // Exemple de chemin absolu

$db_france = 'database/France.db'; // Ajoutez un point-virgule ici

// Vérifiez si la variable $db_france est définie
if (!isset($db_france)) {
    die('La variable $db_france n\'est pas définie.');  // Arrêtez l'exécution si la variable n'est pas définie
}

// // Exécution des fonctions
// supprDatabase($db_france);
// createTables($db_france);
// // insertData($db_france);

// Instancier la classe Requete
$requete = new Requete();
// URL de l'API
$apiUrl = $requete->apiUrl;

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
    foreach ($data['results'] as $record) { // Corrigé de 'results' à 'records'
        // Extraire les informations du record
        $numer_sta = $record['numer_sta'] ?? 'Numéro de station inconnu';
        $nomStation = $record['nom'] ?? 'Nom inconnu';
        $temperature = $record['t'] ?? 'Température inconnue';
        $pression = $record['pres'] ?? 'Pression inconnue';
        $ventVitesse = $record['ff'] ?? 'Vitesse du vent inconnue';
        $longitude = $record['longitude'] ?? 'Longitude inconnue';
        $latitude = $record['latitude'] ?? 'Latitude inconnue';

        echo '<li>
        <h2>Station météorologique : ' . htmlspecialchars($numer_sta) . '</h2>
        <b>Station</b> : ' . htmlspecialchars($nomStation) . '<br>
        <b>Température</b> : ' . htmlspecialchars($temperature) . ' K<br>
        <b>Pression</b> : ' . htmlspecialchars($pression) . ' hPa<br>
        <b>Vitesse du vent</b> : ' . htmlspecialchars($ventVitesse) . ' m/s<br>
        <b>Coordonnées</b> : (' . htmlspecialchars($latitude) . ', ' . htmlspecialchars($longitude) . ')<br>
        </li><br><hr><br>';
    }

    echo '</ul>';
} else {
    echo 'Erreur de décodage JSON : ' . json_last_error_msg(); // Afficher le message d'erreur
}

