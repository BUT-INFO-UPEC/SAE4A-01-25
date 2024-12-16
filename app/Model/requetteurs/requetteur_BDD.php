<?php

namespace App\Model\Requetteurs;

use PDO;

class Requetteur_BDD
{


    /**
     * Récupère les données de la visualisation dans la BDD a partir de son id
     *
     * @param int $reprId Le numéro de visualisation à récupérer.
     * 
     * @return mixed Résultat de la fonction BDD_fetch_visualisation.
     */
    public static function BDD_fetch_visualisation($reprId)
    {
        // methode temporaire(?) tant que la BDD est pas debout (plus lent?)

        // Récupérer le contenu du fichier json et l'interpréter
        $visualisationsJson = file_get_contents(__DIR__ . '/../../database/Representations.json');
        $visualisationsDecodee = json_decode($visualisationsJson);

        // Renvoyer les informations de la visualisation dont l'indice correspond a l'id demandé
        return get_object_vars($visualisationsDecodee[$reprId]);
    }

    /**
     * Récupère les données de la visualisation dans la BDD a partir de son id
     *
     * @param int $composantId Le numéro du composant à récupérer.
     * 
     * @return mixed Résultat de la fonction BDD_fetch_visualisation.
     */
    public static function BDD_fetch_component($composantId)
    {
        // methode temporaire(?) tant que la BDD est pas debout (plus lent?)

        // Récupérer le contenu du fichier json et l'interpréter
        $composantsJson = file_get_contents(__DIR__ . '/../../database/Composants.json');
        $ComposantsDecodes = json_decode($composantsJson);

        // Renvoyer les informations de la visualisation dont l'indice correspond a l'id demandé
        return $ComposantsDecodes[$composantId];
    }

    /**
     * Récupère les dashboards dans la BDD
     * 
     * @return mixed Résultat de la fonction BDD_fetch_visualisation.
     */
    public static function BDD_fetch_dashboards()
    {
        // methode temporaire(?) tant que la BDD est pas debout (plus lent?)

        // Récupérer le contenu du fichier json et l'interpréter
        $dashboardsJson = file_get_contents(__DIR__ . '/../../database/Dashboards.json');
        $DashboardsDecodes = json_decode($dashboardsJson);

        // Renvoyer les informations de la visualisation dont l'indice correspond a l'id demandé
        return $DashboardsDecodes;
    }


    /**
     * récupère l'unité de l'attribut
     * 
     * @param string $attribut L'attribut dont on cherche l'unité
     * 
     * @return string l'unité associé aux mesures de l'attribut passé en paramètre
     */
    public static function BDD_fetch_unit($attribut)
    {
        // methode temporaire(?) tant que la BDD est pas debout (plus lent?)

        // Récupérer le contenu du fichier json et l'interpréter
        $attributsJson = file_get_contents(__DIR__ . '/../../database/Attributs.json');
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
     * Génére un id inutilisé pour un dashboard et ajouter une ligne dans suivi_copiright
     */
    public static function generate_dash_id($originalId)
    {
        $newDashboardId = count(self::BDD_fetch_dashboards());

        self::add_tracing($originalId, $newDashboardId);

        return $newDashboardId;
    }

    /**
     * Vérifie si ce dashboard existe dans la BDD
     * 
     * @param int $dashId
     * 
     * @return bool Le dashboard existe?
     */
    public static function is_saved_dashboard($dashId) {}

    /**
     * Ajoute une ligne dans suivi_copiright pour assurer un tracage des origineaux 
     * 
     * @param int $originalId L'id du dashboard original
     * @param int $nouvId L'id de la "copie"
     */
    public static function add_tracing($originalId, $nouvId) {}

    /**
     * Récupère la chaine de caractère a insérer pour réaliser un groupement API
     * 
     * @param mixed $grouping Le critère de grouppement
     * 
     * @return string La chaine de caractère permettant de faire des grouppements selon els paramètres spécifiés
     */
    public static function get_BDD_grouping_key($grouping)
    {
        if (is_array($grouping)) {
            // vérifier si c'est une liste de stations ou intervals temporels et construire 
        } else {
            $groupingsJson = file_get_contents(__DIR__ . '/../../database/Groupings.json');
            $groupingsDecodes = json_decode($groupingsJson, true);

            foreach ($groupingsDecodes as $group) {
                if ($group["nom"] == $grouping) {
                    return $group["cle"];
                }
            }
        }
    }

    public static function conn_sqlite()
    {
        $db = new PDO('sqlite:' . __DIR__ . '/../../database/France.db');
        return $db;
    }

    public static function get_station()
    {
        $db = self::conn_sqlite();
        $query = $db->prepare("SELECT * FROM stations");
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
}
