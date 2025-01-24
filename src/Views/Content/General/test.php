<?php

// L'URL correcte sans la fonction 'avg(t)' directement dans l'URL
$request = "https://public.opendatasoft.com/api/explore/v2.1/catalog/datasets/donnees-synop-essentielles-omm/records?select=avg(t)&limit=1";

// Initialiser cURL
$ch = curl_init($request);

// Configurer cURL pour retourner la réponse sous forme de chaîne
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json'
));

// Exécuter la requête
$result = curl_exec($ch);

// Vérifier les erreurs de cURL
if(curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    // Décoder la réponse JSON pour la manipuler
    $data = json_decode($result, true);
    
    // Vérifier si des enregistrements existent dans la réponse
    if (isset($data['records']) && count($data['records']) > 0) {
        // Vous pouvez accéder aux données des enregistrements ici, par exemple la première température
        $temperature = $data['records'][0]['fields']['t']; // Exemple d'accès à la température
        echo "Température: " . $temperature;
    } else {
        echo "Aucune donnée trouvée.";
    }
}

// Fermer la session cURL
curl_close($ch);
?>
