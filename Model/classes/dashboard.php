<?php

require_once 'requetteur_BDD.php';
require_once 'requetteur_API.php';
require_once 'composant_dashboard.php';

class Dashboard
{
    // =======================
    //        ATTRIBUTES
    // =======================
    private $dashboardId;
    private $composants = [];
    private $filtres; // gros point d'interrogation


    // =======================
    //      CONSTRUCTOR
    // =======================
    public function __construct($dashboardId)
    {
        $data = BDD_fetch_dashboard($this, $dashboardId);
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
            $data = $this->fetchDataForComposant($composant);
            $output .= $composant->generateVisual($data);
        }
        $output .= "</div>";
        return $output;
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
    private function fetchDataForComposant($composant)
    {
        $attribute = $composant->getAttribut();
        $aggregation = $composant->getAggregation();
        $grouping = $composant->getGrouping();
        return API_request($this->filtres, $attribute, $aggregation, $grouping);
    }
}
