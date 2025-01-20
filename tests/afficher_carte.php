<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carte avec points de radiance</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
  <style>
    #map {
      height: 600px;
      width: 100%;
    }
  </style>
</head>

<body>
  <div id="map"></div>

  <script>
    // Crée la carte et centre sur une position (par exemple, la France)
    var map = L.map('map').setView([46.603354, 1.888334], 6);

    // Ajoute des tuiles OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Fonction pour ajouter des points de radiance
    function addRadiancePoint(lat, lon) {
      var circle = L.circle([lat, lon], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 20000 // Rayon de 20 km pour la radiance
      }).addTo(map);
    }

    // Appel à un fichier PHP pour obtenir les points de radiance
    fetch('get_points.php')
      .then(response => response.json())
      .then(data => {
        data.forEach(point => {
          addRadiancePoint(point.lat, point.lon);
        });
      });
  </script>
</body>

</html>