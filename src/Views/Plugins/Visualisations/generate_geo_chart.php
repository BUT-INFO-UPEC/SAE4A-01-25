<div class="dashboard-card">
    <h4><?= htmlspecialchars($params['titre']) ?></h4>

    <style>
        .leaf {
            width: 400px;
        }
        .legend {
            padding: 6px 8px;
            font: 12px Arial, sans-serif;
            background: white;
            background: rgba(255, 255, 255, 0.8);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            line-height: 18px;
            color: #555;
        }
        .legend i {
            width: 18px;
            height: 18px;
            float: left;
            margin-right: 8px;
            opacity: 0.7;
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

            // Extraction des en-têtes
            const headers = rawData[0];

            // Trouver l'index de la valeur à visualiser (qui n'est ni numer_sta, ni lat, ni lon)
            const valueHeader = headers.find(header =>
                header !== 'numer_sta' && header !== 'lat' && header !== 'lon'
            );

            // Construction d'un tableau d'objets à partir des données
            const stations = rawData.slice(1).map(row => {
                const station = {};
                headers.forEach((key, i) => {
                    station[key] = row[i];
                });
                return station;
            });

            console.log("Stations formatées:", stations);
            console.log("Valeur visualisée:", valueHeader);

            // Calcul des min/max/moyenne pour l'échelle de couleurs
            const values = stations.map(station => station[valueHeader]);
            const minValue = Math.min(...values);
            const maxValue = Math.max(...values);
            const avgValue = (minValue + maxValue) / 2;

            // Fonction pour déterminer la couleur en fonction de la valeur
            function getColor(value) {
                // Interpolation entre bleu (min), jaune (moyenne), rouge (max)
                const ratio = (value - minValue) / (maxValue - minValue);

                if (ratio < 0.5) {
                    // Bleu vers jaune
                    const r = Math.floor(ratio * 2 * 255);
                    const g = Math.floor(ratio * 2 * 255);
                    const b = Math.floor(255 - (ratio * 2 * 255));
                    return `rgb(${r}, ${g}, ${b})`;
                } else {
                    // Jaune vers rouge
                    const r = 255;
                    const g = Math.floor(255 - ((ratio - 0.5) * 2 * 255));
                    const b = 0;
                    return `rgb(${r}, ${g}, ${b})`;
                }
            }

            // Fonction pour déterminer le rayon en fonction de la valeur
            function getRadius(value) {
                // Rayon proportionnel à la valeur (entre 5 et 15)
                const minRadius = 5;
                const maxRadius = 15;
                return minRadius + ((value - minValue) / (maxValue - minValue)) * (maxRadius - minRadius);
            }

            // Initialisation de la carte (centrée sur la première station)
            const map = L.map("map-station").setView([stations[0].lat, stations[0].lon], 5);

            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: "&copy; OpenStreetMap contributors"
            }).addTo(map);

            // Ajout des cercles colorés pour chaque station
            stations.forEach(station => {
                const value = station[valueHeader];

                L.circleMarker([station.lat, station.lon], {
                    radius: getRadius(value),
                    fillColor: getColor(value),
                    color: "#000",
                    weight: 1,
                    opacity: 1,
                    fillOpacity: 0.8
                }).addTo(map)
                .bindPopup(`
                    <strong>${station.name}</strong><br>
                    ${valueHeader.replace(
						/_/g, " ").replace(/([a-z])([A-Z])/g, "$1 $2"
					)}: ${value.toFixed(2)}
                `);
            });

            // Ajout de la légende
            const legend = L.control({position: 'bottomright'});

            legend.onAdd = function (map) {
                const div = L.DomUtil.create('div', 'legend');
                const grades = [minValue, avgValue, maxValue];
                const labels = [];

                // Génération du gradient de couleur pour la légende
                div.innerHTML = `
                    <div><strong>${valueHeader}</strong></div>
                    <div style="background: linear-gradient(to right, blue, yellow, red); height: 20px; margin: 5px 0;"></div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>${minValue.toFixed(2)}</span>
                        <span>${avgValue.toFixed(2)}</span>
                        <span>${maxValue.toFixed(2)}</span>
                    </div>
                `;

                return div;
            };

            legend.addTo(map);
        });
    </script>
</div>
