<?php
// POTENTIELS INCLUDES ET CODE PHP

// Démarrer la mise en tampon pour capturer le contenu spécifique
ob_start();
?>

<h1>Visualisation des données</h1>

<?php
require_once "../Model/classes/Dashboard.php";
$dash = new Dashboard(0);

echo $dash->generate_dashboard();
// Récupération du contenu html/php
$main = ob_get_clean();
// Chargement du Layout APRES avoir Récupérer le contenu pour qu'il puisse le mettre en forme
include "../layout/Layout.php";
?>