<?php
require_once "../Model/entete.php";

// Démarrer la mise en tampon pour capturer le contenu spécifique
ob_start();
?>

<form method="GET" class="dashboard-search">
    <input type="text" placeholder="Rechercher un Dashboard">
    <button type="submit">Rechercher</button>
</form>

<?php
// Récupération du contenu html/php
$main = ob_get_clean();
// Chargement du Layout APRES avoir Récupérer le contenu pour qu'il puisse le mettre en forme
include "../layout/Layout.php";
?>
