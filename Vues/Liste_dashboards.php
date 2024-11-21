<?php
require_once "../Model/classes/Dashboard.php";
// Démarrer la mise en tampon pour capturer le contenu spécifique
ob_start();

foreach (Dashboard::get_dashboards() as $dash) {
    # code...
}

// Récupération du contenu html/php
$main = ob_get_clean();
// Chargement du Layout APRES avoir Récupérer le contenu pour qu'il puisse le mettre en forme
include "../layout/Layout.php";
?>