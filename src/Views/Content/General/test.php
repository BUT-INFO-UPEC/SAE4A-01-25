<?php

use Src\Model\Repository\Requetteur_API;

$table = [
    'select' => ['min(t)', 'max(t)', 'avg(t)', 'count(*)'],
    'where' => 'libgeo="Abbeville"'
];

// Construction de la query string
$params = [];
foreach ($table as $key => $value) {
    if (is_array($value)) {
        $value = implode(',', $value); // Combiner les valeurs du tableau
    }
    $params[$key] = $value;
}

$queryString = "?" . http_build_query($params);
$requette = "https://public.opendatasoft.com/api/explore/v2.1/catalog/datasets/donnees-synop-essentielles-omm/records";
$url = $requette . $queryString;

// Afficher l'URL générée
echo "Generated URL: $url<br>";

// Appel API
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

// Vérification des erreurs curl
if (curl_errno($ch)) {
    echo "Curl error: " . curl_error($ch);
    curl_close($ch);
    exit;
}

curl_close($ch);

// Décodage de la réponse JSON
$data = json_decode($response, true);

if (isset($data['results']) && is_array($data['results'])) {
    $results = $data['results'];
} else {
    echo "Aucune donnée trouvée ou erreur dans la réponse de l'API.";
    exit;
}

?>


<div class="row">
    <?php foreach ($results as $result) : ?>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($result['libgeo'] ?? 'Inconnu') ?></h5>
                    <p class="card-text">Température : <?= htmlspecialchars($result['tc'] ?? 'Non disponible') ?>°C</p>
                    <p class="card-text">Date : <?= htmlspecialchars($result['date'] ?? 'Non disponible') ?></p>
                    <p class="card-text">Pression : <?= htmlspecialchars($result['pmer'] ?? 'Non disponible') ?> hPa</p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>