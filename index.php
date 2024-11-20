<?php
// POTENTIELS INCLUDES ET CODE PHP

// Démarrer la mise en tampon pour capturer le contenu spécifique
ob_start();
?>

<h1><a href="ReadMe.md"> LISEZ MOI !!! </a></h1>

<h2> Vues </h2>
<?php
$dossier = "./Vues";
include "layout/composants_balistiques_specifiques/Scandir.php";

echo "<h2> Tests </h2>";
$dossier = "./tests";
include "layout/composants_balistiques_specifiques/Scandir.php";


// Récupération du contenu html/php
$main = ob_get_clean();
// Chargement du Layout APRES avoir Récupérer le contenu pour qu'il puisse le mettre en forme
include "layout/Layout.php";
?>