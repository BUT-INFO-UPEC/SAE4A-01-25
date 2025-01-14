Fichier contenant les pages finales que l'utilisateur charge
contenu d'une actions:


<?php
// POTENTIELS INCLUDES ET CODE PHP

// Démarrer la mise en tampon pour capturer le contenu spécifique
ob_start();
?>

CONTENU HTML/PHP

<?php
// Récupération du contenu html/php
$main = ob_get_clean();
// Chargement du Layout APRES avoir Récupérer le contenu pour qu'il puisse le mettre en forme
include "../layout/Layout.php";
?>