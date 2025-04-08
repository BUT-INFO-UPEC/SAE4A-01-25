<div class="dashboard-card">
	<h4>
	<?= htmlspecialchars($params['titre']) ?>
	</h4>

<style>
	.leaf{
		width: 400px;

	}
</style>
	<div class="leaf">


		<div id="map-station" style="height: 400px; border-radius: 10px;"></div>

	</div>
	<!-- Leaflet CSS & JS -->
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
	<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

	<script>
		document.addEventListener("DOMContentLoaded", function() {
			// Données PHP
			const rawData = <?= json_encode($data) ?>;
			console.log("Données brutes:", rawData);

			// Extraction des clés depuis la première ligne
			const headers = rawData[0];

			// Construction d'un tableau d'objets à partir des lignes suivantes
			const stations = rawData.slice(1).map(row => {
				const station = {};
				headers.forEach((key, i) => {
					station[key] = row[i];
				});
				return station;
			});

			console.log("Stations formatées:", stations);

			// Initialisation de la carte (centrée sur la première station)
			const map = L.map("map-station").setView([stations[0].lat, stations[0].lon], 5);

			L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
				attribution: "&copy; OpenStreetMap contributors"
			}).addTo(map);

			// Ajout des marqueurs
			stations.forEach(station => {
				const tempC = (station.Moyenne_Temperature_K - 273.15).toFixed(1);
				L.marker([station.lat, station.lon]).addTo(map)
					.bindPopup(`
                        <strong>Station ${station.numer_sta}</strong><br>
                        Température moyenne : ${tempC}
                    `);
			});
		});
	</script>
</div>
