<?php
// POTENTIELS INCLUDES ET CODE PHP

// Démarrer la mise en tampon pour capturer le contenu spécifique
ob_start();
?>

<h1><a href="ReadMe.txt"> LISEZ MOI !!! </a></h1>

<?php
$dossier = "./Vues";
include "layout/Scandir.php";

// Récupération du contenu html/php
$main = ob_get_clean();
// Chargement du Layout APRES avoir Récupérer le contenu pour qu'il puisse le mettre en forme
include "layout/Layout.php";
?>