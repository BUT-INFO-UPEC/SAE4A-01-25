<?php

namespace App\Views\Actions;

require_once __DIR__ .  "/../../Model/entete.php";

use App\Model\Classes\Dashboard;

// si le dashboard n'est ni initialisé ni défini par son id, retour a l'acceuil car aucun dashboard n'est séléctionné donc affichable
if (isset($_GET['dashId'])) {
    $_SESSION["curent_dashboard"] = Dashboard::get_dashboard_by_id($_GET['dashId']);
} else if (!isset($_SESSION["curent_dashboard"])) {
    // out("pas de d'idDashboard");
    header("Location: " . HOME_PAGE); // redirection
}
// var_dump($_SESSION["curent_dashboard"]);
// le dashboard a afficher est selui séléctionné (dans la session)
$dash = $_SESSION["curent_dashboard"];

// Démarrer la mise en tampon pour capturer le contenu spécifique
ob_start();
?>

<button class="dropdown" style="position: absolute; right: 0;">
    modifier
</button>

<h1 class="centered"> Nom météothèque </h1>

<div class="container">
    <h3 class="centered"> Stations analysées </h3>

    <hr />

    <div class="flex">
        <div class="container">
            <h3> Zone(s) géographique(s) </h3>

            <p class="changing"> liste noms stations/ communes/ départements </p>

            <button> Accéder a la liste des stations </button>
        </div>

        <div class="container">
            <div class="flex">
                <h3 style="flex-grow: 1"> Periode temporelle </h3>

                <p> Météothèque <?php echo htmlspecialchars($dash->dateFinRelatif ? 'Oui' : 'Non'); ?></p>
            </div>

            <p> début : <span class="changing">JJ/MMAAA</span></p>

            <p> fin : <span class="changing">JJ/MMAAA</span></p>
        </div>
    </div>
</div>

<div class="container">
    <h3> Commentaires </h3>

    <p class="changing"> Explication des analyses de la météothèque par le créateur </p>
</div>

<div class="container centered">
    <h3> Visualisation du dashboard </h3>

    <hr />

    <?php echo $dash->generate_dashboard() ?>
</div>

<?php
// Récupération du contenu html/php
$main = ob_get_clean();
// Chargement du Layout APRES avoir Récupérer le contenu pour qu'il puisse le mettre en forme
include "../Layout.php";
?>