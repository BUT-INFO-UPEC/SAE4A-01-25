<?php
// POTENTIELS INCLUDES ET CODE PHP
require_once "Model/classes/Dashboard.php";
$_SESSION["curent_dashboard"] = Dashboard::get_dashboard_by_id(0);

// Démarrer la mise en tampon pour capturer le contenu spécifique
ob_start();
?>

<h1><a href="ReadMe.md"> LISEZ MOI !!! </a></h1>

<h2> Vues </h2>
<?php
// afficher un liste de liens vers les fichiers du dossier Vues
$dossier = 'Vues';
include "layout/composants_balistiques_specifiques/Scandir.php";

echo "<h2> Tests </h2>";
// afficher un liste de liens vers les fichiers du dossier tests
$dossier = "tests";
include "layout/composants_balistiques_specifiques/Scandir.php";


// Récupération du contenu html/php
$main = ob_get_clean();
// Chargement du Layout APRES avoir Récupérer le contenu pour qu'il puisse le mettre en forme
include "layout/Layout.php";
?>