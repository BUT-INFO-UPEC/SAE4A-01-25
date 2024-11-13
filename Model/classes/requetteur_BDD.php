<?php

function BDD_fetch_visualisation($reprId){
    // methode temporaire(?) tant que la BDD est pas debout (plus lent?)

    // Récupérer le contenu du fichier json et l'interpréter
    $visualisationsJson = file_get_contents('../database/Representations.json');
    $visuailsationDecodee = json_decode($visualisationsJson);

    // Renvoyer les informations de la visualisation dont l'indice correspond a l'id demandé
    return $visuailsationDecodee[$reprId];
}

function BDD_fetch_component($objectToBuild, $composantId){}

function BDD_fetch_dashboard($objectToBuild, $composantId){}
?>