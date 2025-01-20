<?php
// Vérifie si le dossier existe
if (is_dir($dossier)) {
  // Récupère la liste des fichiers
  $fichiers = scandir($dossier);

  echo '<nav><ul>';
  // Parcourt chaque fichier dans le dossier
  foreach ($fichiers as $fichier) {
    // Ignore les liens vers le dossier parent et le dossier courant
    if ($fichier !== '.' && $fichier !== '..') {
      // Crée le lien pour chaque fichier
      echo '<li><a href="' . $dossier . '/' . $fichier . '">' . substr($fichier, 0, -4) . '</a></li>';
    }
  }
  echo '</ul></nav>';
} else {
  echo "Dossier non trouvé.";
}
