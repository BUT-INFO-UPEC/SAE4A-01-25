<?php

require_once 'requetteur_BDD.php';
require_once 'requetteur_API.php';
require_once 'composant_dashboard.php';

class Dashboard {
    private $dashboardId;
    private $composants = [];

    public function __construct($dashboardId) {
        BDD_fetch_dashboard($this, $dashboardId);
    }

    // tt les set et les get

    // Récupérer les données pour chaque composant et générer les visualisations
    public function generateDashboard() {
        $output = "<div class='dashboard'>";
        foreach ($this->composants as $composant) {
            $data = $this->fetchDataForComposant($composant);
            $output .= $composant->generateVisual($data);
        }
        $output .= "</div>";
        return $output;
    }

    // Simuler la récupération de données via l'API
    private function fetchDataForComposant($composant) {
        $attribute = $composant->attribut;
        $aggregation = $composant->aggregation;
        $grouping = $composant->groupping;
        return API_request($attribute, $aggregation, $grouping);
    }
}
?>
