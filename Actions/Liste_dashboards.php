<?php
require_once "../Model/classes/Dashboard.php";
// Démarrer la mise en tampon pour capturer le contenu spécifique
ob_start();


echo "<ul>";
foreach (Dashboard::get_dashboards() as $dash) {
    $lien = dirname($_SERVER['PHP_SELF']) . "/visu_dashboard?dashId=" . $dash->get_id();
    echo "<li><a href=\"$lien\">" . $dash->get_name() . "</a></li>";
}
echo "</ul>";

// Récupération du contenu html/php
$main = ob_get_clean();
// Chargement du Layout APRES avoir Récupérer le contenu pour qu'il puisse le mettre en forme
include "../layout/Layout.php";
?>