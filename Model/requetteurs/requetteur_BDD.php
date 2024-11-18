<?php

/**
 * Récupère les données de la visualisation dans la BDD a partir de son id
 *
 * @param int $reprId Le numéro de visualisation à récupérer.
 * @return mixed Résultat de la fonction BDD_fetch_visualisation.
 */
function BDD_fetch_visualisation($reprId)
{
    // methode temporaire(?) tant que la BDD est pas debout (plus lent?)

    // Récupérer le contenu du fichier json et l'interpréter
    $visualisationsJson = file_get_contents('../database/Representations.json');
    $visualisationsDecodee = json_decode($visualisationsJson);

    // Renvoyer les informations de la visualisation dont l'indice correspond a l'id demandé
    return get_object_vars($visualisationsDecodee[$reprId]);
}

/**
 * Récupère les données de la visualisation dans la BDD a partir de son id
 *
 * @param int $composantId Le numéro du composant à récupérer.
 * @return mixed Résultat de la fonction BDD_fetch_visualisation.
 */
function BDD_fetch_component($composantId) {
    // methode temporaire(?) tant que la BDD est pas debout (plus lent?)

    // Récupérer le contenu du fichier json et l'interpréter
    $composantsJson = file_get_contents('../database/Composants.json');
    $ComposantsDecodes = json_decode($composantsJson);

    // Renvoyer les informations de la visualisation dont l'indice correspond a l'id demandé
    return $ComposantsDecodes[$composantId];
}

/**
 * Récupère les données de la visualisation dans la BDD a partir de son id
 *
 * @param int $composantId Le numéro du dashboard à récupérer.
 * @return mixed Résultat de la fonction BDD_fetch_visualisation.
 */
function BDD_fetch_dashboard($composantId)
{
    // methode temporaire(?) tant que la BDD est pas debout (plus lent?)

    // Récupérer le contenu du fichier json et l'interpréter
    $dashboardsJson = file_get_contents('../database/Dashboards.json');
    $DashboardsDecodes = json_decode($dashboardsJson);

    // Renvoyer les informations de la visualisation dont l'indice correspond a l'id demandé
    return $DashboardsDecodes[$composantId];
}

/**
 * récupère l'unité de l'attribut
 * 
 * @param string $attribut L'attribut dont on cherche l'unité
 * @return string l'unité associé aux mesures de l'attribut passé en paramètre
 */
function BDD_fetch_unit($attribut) {
    // methode temporaire(?) tant que la BDD est pas debout (plus lent?)

    // Récupérer le contenu du fichier json et l'interpréter
    $attributsJson = file_get_contents('../database/Attributs.json');
    $attributsDecodes = json_decode($attributsJson, true);

    foreach ($attributsDecodes as $att) {
        if ($att["key"] == $attribut) {
            if (isset($att["unit"])) return $att["unit"];
            else return "";
        }
    }
    return "";
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

