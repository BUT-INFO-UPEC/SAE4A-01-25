<?php
// Charger le fichier SVG
$svgPath = __DIR__ . "/../../../../assets/img/carte_france_svg.svg";
$svgContent = file_get_contents($svgPath);

if ($svgContent === false) {
    die("Erreur lors du chargement de la carte SVG.");
}

// Ajouter des liens autour des régions
$svgContent = preg_replace_callback(
    '/<path([^>]*)id="([^"]+)"([^>]*)>/',
    function ($matches) {
        $attributes = $matches[1] . $matches[3];
        $regionId = $matches[2];
        $link = '<a xlink:href="?region=' . urlencode($regionId) . '">';
        return $link . '<path' . $attributes . 'id="' . $regionId . '" /></a>';
    },
    $svgContent
);

// Afficher le SVG modifié
echo $svgContent;

// Si une région est cliquée, elle sera disponible dans $_GET['region']
if (isset($_GET['region'])) {
    $region = htmlspecialchars($_GET['region']);
    echo "Région sélectionnée : " . $region;
}
