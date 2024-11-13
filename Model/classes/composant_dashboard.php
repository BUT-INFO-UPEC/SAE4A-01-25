<?php

require_once 'requetteur_BDD.php';

class Composant {
    private $composantId;
    private $attribut;
    private $aggregation;
    private $grouping;
    private $reprId;
    private $repr;
    private $params;

    public function __construct($composantId) {
        BDD_fetch_component($this, $composantId);
    }

    // tt les set et gets
    public function setRepr($reprId) {
        $this->reprId = $reprId;
        // Récupérer les détails de la représentation
        $this->repr = BDD_fetch_visualisation($reprId);
    }

    // Méthode pour générer la représentation visuelle
    public function generateVisual($data) {

        $formateur = $this->repr["data_formateur"];

        if (function_exists($formateur)) {
            // Appeler dynamiquement la fonction
            $donneesFormatees = call_user_func($formateur, $data);
        } else {
            $donneesFormatees = $data;
        }

        // Récupérer le nom de la fonction
        $constructor = $this->repr['visualisation_constructor'];
        
        if (function_exists($constructor)) {
            // Appeler dynamiquement la fonction
            return call_user_func($constructor, $donneesFormatees, $this->params);
        } else {
            return "<p>Unsupported representation</p>";
        }
    }

}
?>