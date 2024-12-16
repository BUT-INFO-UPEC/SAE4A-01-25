<?php

namespace App\Views;

use App\Model\Requetteurs\Requetteur_BDD;

require_once "../Model/entete.php";
require_once __DIR__ . "/../Model/requetteurs/requetteur_BDD.php";

$station = Requetteur_BDD::get_station();


// Démarrer la mise en tampon pour capturer le contenu spécifique
ob_start();

include __DIR__ . "/Profil/Actions/profil.php";

// Récupération du contenu html/php
$main = ob_get_clean();
// Chargement du Layout APRES avoir Récupérer le contenu pour qu'il puisse le mettre en forme
include "Layout.php";
