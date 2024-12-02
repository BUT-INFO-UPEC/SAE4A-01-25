<!-- page Profil -->
<?php
require_once "../Model/entete.php";
require_once __DIR__ . "/../Model/requetteurs/requetteur_BDD.php";

$station = get_station();


// Démarrer la mise en tampon pour capturer le contenu spécifique
ob_start();
?>
<?php
for ($i = 0; $i < 0; $i++) {
    echo "test $i";
}
?>
<?php
// Récupération du contenu html/php
$main = ob_get_clean();
// Chargement du Layout APRES avoir Récupérer le contenu pour qu'il puisse le mettre en forme
include "../layout/Layout.php";
?>