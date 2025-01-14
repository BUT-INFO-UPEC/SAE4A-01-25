<?php

include "modules_php/requete.php";  // Vérifiez le chemin de ce fichier
include "database/crea_BDD_stations.php";  // Exemple de chemin absolu

$db_france = 'database/France.db'; // Ajoutez un point-virgule ici

// Vérifiez si la variable $db_france est définie
if (!isset($db_france)) {
    die('La variable $db_france n\'est pas définie.');  // Arrêtez l'exécution si la variable n'est pas définie
}

// // Exécution des fonctions
// supprDatabase($db_france);
// createTables($db_france);
// // insertData($db_france);

// URL de l'API
$apiUrl = "https://public.opendatasoft.com/api/explore/v2.1/catalog/datasets/donnees-synop-essentielles-omm/records";

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
    foreach ($data['records'] as $record) { // Correction du tableau à 'records'
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
?>

<!-- Bouton pour ouvrir le popup de connexion -->
<button onclick="openPopup()">Connexion</button>

<!-- Code HTML du popup de connexion -->
<div class="popup-overlay" id="popup" style="display: none;">
    <div class="popup-content">
        <h2>Connexion</h2>
        <form action="traitement_connexion.php" method="post">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>
        <button onclick="closePopup()">Fermer</button>
    </div>
</div>

<!-- Script pour ouvrir et fermer le popup -->
<script>
    function openPopup() {
        document.getElementById("popup").style.display = "flex";
    }
    function closePopup() {
        document.getElementById("popup").style.display = "none";
    }
</script>

<!-- Styles du popup, on peut ajouter sa dans un autre fichier CSS -->
<style>
    .popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .popup-content {
        background-color: #fff;
        padding: 20px;
        width: 300px;
        border-radius: 8px;
        text-align: center;
    }
    .popup-content input[type="text"],
    .popup-content input[type="password"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
    }
    .popup-content button {
        padding: 10px 20px;
        cursor: pointer;
    }
</style>
