<?php

/**
 * Récupère les données de la visualisation dans la BDD a partir de son id
 *
 * @param int $numero Le numéro de visualisation à récupérer.
 * @return mixed Résultat de la fonction BDD_fetch_visualisation.
 */
function BDD_fetch_visualisation($reprId)
{
    // methode temporaire(?) tant que la BDD est pas debout (plus lent?)

    // Récupérer le contenu du fichier json et l'interpréter
    $visualisationsJson = file_get_contents('../database/Representations.json');
    $visuailsationDecodee = json_decode($visualisationsJson);

    // Renvoyer les informations de la visualisation dont l'indice correspond a l'id demandé
    return $visuailsationDecodee[$reprId];
}

/**
 * Récupère les données de la visualisation dans la BDD a partir de son id
 *
 * @param int $numero Le numéro de visualisation à récupérer.
 * @return None Résultat de la fonction BDD_fetch_visualisation.
 */
function BDD_fetch_component($composantId) {}

/**
 * Récupère les données de la visualisation dans la BDD a partir de son id
 *
 * @param int $numero Le numéro de visualisation à récupérer.
 * @return mixed Résultat de la fonction BDD_fetch_visualisation.
 */
function BDD_fetch_dashboard($composantId)
{
    // methode temporaire(?) tant que la BDD est pas debout (plus lent?)

    // Récupérer le contenu du fichier json et l'interpréter
    $visualisationsJson = file_get_contents('../database/Dashboards.json');
    $visuailsationDecodee = json_decode($visualisationsJson);

    // Renvoyer les informations de la visualisation dont l'indice correspond a l'id demandé
    return $visuailsationDecodee[$composantId];
}

/**
 * Génére un id inutilisé pour un dashboard
 */
function generate_dash_id() {}

/**
 * Vérifie si ce dashboard existe dans la BDD
 * 
 * @param int $dashId
 * @return bool Le dashboard existe?
 */
function is_saved_dashboard($dashId) {}

/**
 * Ajoute une ligne dans suivi_copiright pour assurer un tracage des origineaux 
 * 
 * @param int $originalId L'id du dashboard original
 * @param int $nouvId L'id de la "copie"
 */
function add_tracing($originalId, $nouvId) {}