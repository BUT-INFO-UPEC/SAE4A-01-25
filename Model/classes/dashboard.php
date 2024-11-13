<?php

use function PHPSTORM_META\override;

require_once 'requetteur_BDD.php';
require_once 'requetteur_API.php';
require_once 'composant_dashboard.php';

class Dashboard
{
    // =======================
    //        ATTRIBUTES
    // =======================
    private $dashboardId;
    private $privatisation;
    private $composants = [];
    private $createurId;
    private $filtres; // gros point d'interrogation


    // =======================
    //      CONSTRUCTOR
    // =======================
    public function __construct($dashboardId)
    {
        $data = BDD_fetch_dashboard($dashboardId);
        $this->dashboardId = $dashboardId;
    }

    // =======================
    //    PUBLIC METHODS
    // =======================
    /**
     * Récupérer les données pour chaque composant et générer les visualisations
     * 
     * @return string la chaine de caractères compilant la visualisation des données de chacuns des composants du dashboard
     */
    public function generateDashboard()
    {
        $output = "<div class='dashboard'>";
        foreach ($this->composants as $composant) {
            $data = $this->fetch_data_for_composant($composant);
            $output .= $composant->generateVisual($data);
        }
        $output .= "</div>";
        return $output;
    }

    /**
     * Exporte et sauvegarde le dashboard dans la BDD
     * 
     * @param bool $override L'utilisateur veut écraser l'ancienne version de son Dashboard
     */
    public function save_dashboard($override)
    {
        // Vérifier l'appartenance
        if ($this->createurId == $_SESSION["userId"]) {
            // générer un nouvel id et ajouter une ligne dans suivi_copiright
            $originalId = $this->dashboardId;
            $this->dashboardId = generate_dash_id();
            add_tracing($originalId, $this->dashboardId);
        } elseif ($override && is_saved_dashboard($this->dashboardId)) {
            // lever une exception pour affichier un message a 'utilisateur pour lui demander confirmation de l'écrasement du dashboard enregistré, et donc everride, si il veut faire une copie auquel cas, lui générer un nouveau id (generate_dash_id()) ou si il veut anuler
            throw new Exception("Tentative de sauvegarder un dashboard déja existant.", 301);
        }

        //exporter et sauvegarder
    }

    // =======================
    //    PRIVATE METHODS
    // =======================
    /** 
     * Récupération des données via l'API 
     * 
     * @param Composant $composant L'objet dont les données doivent etres récupérées
     * @return array La liste des données selon les critères spécifiés
     */
    private function fetch_data_for_composant($composant)
    {
        $attribute = $composant->getAttribut();
        $aggregation = $composant->getAggregation();
        $grouping = $composant->getGrouping();
        return API_request($this->filtres, $attribute, $aggregation, $grouping);
    }
}
