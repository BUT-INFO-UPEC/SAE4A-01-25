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

<!-- Styles CSS pour dimensionner et centrer la carte SVG -->
<style>
	#map-container {
		display: flex;
		justify-content: center;
		align-items: center;
		width: 100%;
		height: 80vh;
		/* Ajuste la hauteur à 80% de la fenêtre */
		margin: 20px auto;
	}

	#map {
		width: 100%;
		height: 100%;
		max-width: 800px;
		/* Limite la largeur maximale */
		max-height: 100%;
		border: 1px solid #ddd;
		background: #f9f9f9;
		border-radius: 8px;
		box-shadow: 2px 4px 10px rgba(0, 0, 0, 0.1);
		cursor: pointer;
	}

	#map path {
		transition: fill 0.3s ease, stroke 0.3s ease;
	}

	#map path:hover {
		fill: #007bff !important;
		/* Mettre en surbrillance la région au survol */
		stroke: #0056b3 !important;
	}
</style>

<!-- Afficher le contenu SVG -->
<div id="map-container">
	<?= $svgContent ?>
</div>

<?php
// Si une région est cliquée, elle sera disponible dans $_GET['region']
if (isset($_GET['region'])) {
	$region = htmlspecialchars($_GET['region']);
	echo "<p>Région sélectionnée : " . $region . "</p>";
}
?>

<script>
	document.addEventListener('DOMContentLoaded', function () {
		const paths = document.querySelectorAll('#map path');
		paths.forEach(path => {
			path.addEventListener('click', function (e) {
				const regionId = e.target.id;
				if (regionId) {
					console.log(`Région cliquée : ${regionId}`);
					window.location.href = `?region=${encodeURIComponent(regionId)}`;
				}
			});
		});
	});
</script>