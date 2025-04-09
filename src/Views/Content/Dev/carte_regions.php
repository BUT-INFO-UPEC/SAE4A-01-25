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
		return '<a href="?controller=ControllerDev&action=browse&region=' . urlencode($regionId) . '"><path' . $attributes . ' id="' . $regionId . '" /></a>';
	},
	$svgContent
);
?>

<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style_carte.css">

<!-- Afficher le contenu SVG -->
<div id="map-container">
	<?= $svgContent ?>
</div>


<script>
	document.addEventListener('DOMContentLoaded', function() {
		const paths = document.querySelectorAll('#map path');
		paths.forEach(path => {
			path.addEventListener('click', function(e) {
				const regionId = e.target.id;
				console.log(regionId);

				if (regionId) {
					console.log(`Région cliquée : ${regionId}`);
					window.location.href = `?action=browse&region=${encodeURIComponent(regionId)}`;
				}
			});
		});
	});
</script>