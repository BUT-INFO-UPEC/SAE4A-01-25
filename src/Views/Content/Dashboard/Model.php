<?php
require_once "../../Model/entete.php";

// POTENTIELS INCLUDES ET CODE PHP

// Démarrer la mise en tampon pour capturer le contenu spécifique
ob_start();
?>

CONTENU HTML/PHP

<?php
// Récupération du contenu html/php
$main = ob_get_clean();
// Chargement du Layout APRES avoir Récupérer le contenu pour qu'il puisse le mettre en forme
include "../Layout.php";
?>