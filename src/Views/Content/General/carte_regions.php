<?php
// Charger le fichier SVG depuis le fichier uploadé
$svgPath = __DIR__ . "/../../../../assets/img/carte_france_svg.svg";
$svgContent = file_get_contents($svgPath);

if ($svgContent === false) {
    die("Erreur lors du chargement de la carte SVG.");
}

// Ajouter un ID au tag <svg>
$svgContent = preg_replace('/<svg([^>]*)>/', '<svg\1 id="map">', $svgContent);

// Ajouter des liens autour des régions
$svgContent = preg_replace_callback(
    '/<path([^>]*)id="([^"]+)"([^>]*)>/',
    function ($matches) {
        $attributes = $matches[1] . $matches[3];
        $regionId = $matches[2];
        return '<path' . $attributes . 'id="' . $regionId . '" />';
    },
    $svgContent
);
?>

<!-- Afficher le contenu SVG -->
<div>
    <?= $svgContent ?>
</div>

<?php
// Si une région est cliquée, elle sera disponible dans $_GET['region']
if (isset($_GET['region'])) {
    $region = htmlspecialchars($_GET['region']);
    echo "Région sélectionnée : " . $region;
}
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paths = document.querySelectorAll('#map path');
        paths.forEach(path => {
            path.addEventListener('click', function(e) {
                const regionId = e.target.id;
                if (regionId) {
                    console.log(`Région cliquée : ${regionId}`);
                    window.location.href = `?region=${encodeURIComponent(regionId)}`;
                }
            });
        });
    });
</script>
