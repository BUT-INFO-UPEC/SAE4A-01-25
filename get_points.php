<?php
// Exemple de points de radiance définis manuellement
$points = [
    ['lat' => 48.8566, 'lon' => 2.3522],  // Paris
    ['lat' => 43.6047, 'lon' => 1.4442],  // Toulouse
    ['lat' => 45.7640, 'lon' => 4.8357],  // Lyon
    ['lat' => 50.6292, 'lon' => 3.0573],  // Lille
];

// Retourne les points en format JSON
header('Content-Type: application/json');
echo json_encode($points);
