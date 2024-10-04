<?php

require_once 'requetteur_BDD.php';

class Composant {
    private $composantId;
    private $attribut;
    private $aggregation;
    private $grouping;
    private $repr;
    private $data;
    private $params;

    public function __construct($composantId) {
        BDD_fetch_component($this, $composantId);
    }

    // tt les set et gets
    public function setRepr($reprId) {
        // Récupérer les détails de la représentation
        $this->repr = BDD_fetch_visualisation($reprId);
    }

    // Méthode pour générer la représentation visuelle
    public function generateVisual($data) {

        $formater = $this->repr["data_formater"];

        if (function_exists($formater)) {
            // Appeler dynamiquement la fonction
            $formatedData = call_user_func($formater, $data);
        } else {
            $formatedData = $data;
        }

        // Récupérer le nom de la fonction
        $constructor = $this->repr['visualisation_constructor'];
        
        if (function_exists($constructor)) {
            // Appeler dynamiquement la fonction
            return call_user_func($constructor, $formatedData, $this->params);
        } else {
            return "<p>Unsupported representation</p>";
        }
    }

}
?>