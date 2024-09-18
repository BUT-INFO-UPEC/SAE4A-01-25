<?php
// URL de l'API
$apiUrl = 'https://public.opendatasoft.com/api/explore/v2.1/catalog/datasets/donnees-synop-essentielles-omm/records';

// Initialiser une session cURL
$ch = curl_init();

// Configurer les options de cURL
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Désactiver la vérification SSL (à utiliser avec prudence)

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
    echo '<h1>Données de l\'API</h1>';
    echo '<ul>';

    // Assurez-vous de modifier ceci en fonction de la structure de vos données
    foreach ($data['records'] as $record) {
        $fields = $record['fields'];
        echo '<li>';
        echo 'Nom: ' . htmlspecialchars(isset($fields['nom']) ? $fields['nom'] : 'Inconnu') . '<br>';
        echo 'Température: ' . htmlspecialchars(isset($fields['temperature']) ? $fields['temperature'] : 'Inconnue') . '<br>';
        // Ajoutez d'autres champs que vous souhaitez afficher
        echo '</li>';
    }

    echo '</ul>';
} else {
    echo 'Erreur de décodage JSON.';
}
?>
