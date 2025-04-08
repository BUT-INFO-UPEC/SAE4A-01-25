<div class='dashboard-card' id='comp<?= $params['chartId'] ?>'>
    <h4><?= htmlspecialchars($params['titre']) ?></h4>

    <!-- Conteneur pour la carte -->
    <div id="map<?= $params['chartId'] ?>" style="height: 300px; border-radius: 10px;"></div>

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
	<pre><?php var_dump($data); ?></pre>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var rawData = <?= json_encode($data) ?>;
            console.log("Données reçues:", rawData);

            var lat = rawData[2] !== undefined ? rawData["lat"] : null;
            var lon = rawData[3] !== undefined ? rawData["lon"] : null;

            if (lat !== null && lon !== null) {
                var map = L.map("map<?= $params['chartId'] ?>").setView([lat, lon], 13);

                L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                    attribution: "&copy; OpenStreetMap contributors"
                }).addTo(map);

                L.marker([lat, lon]).addTo(map)
                    .bindPopup("Station ici !")
                    .openPopup();
            } else {
                document.getElementById("map<?= $params['chartId'] ?>").innerHTML = "<p style='text-align:center; padding: 50px;'>Coordonnées non disponibles</p>";
            }
        });
    </script>
</div>
