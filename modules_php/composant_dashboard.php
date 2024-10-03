<?php

require_once 'requetteur_BDD.php';

class Composant {
    private $composantId;
    private $attribut;
    private $aggregation;
    private $grouping;
    private $reprType;
    private $data;
    private $paramAffich;

    public function __construct($composantId) {
        BDD_fetch_component($this, $composantId);
    }

    // tt les set et gets

    // Méthode pour générer la représentation visuelle
    public function generateVisual($data) {
        $formatedData = "récupérer le formateur de données pour le type de données a partir de son id (reprType), surement avec un chemin dans la BDD"($data);
        $fonctionConstructeur = "récupérer le constructeur a partir de son id (reprType), surement avec un chemin dans la BDD";
        return $fonctionConstructeur($formatedData);
    }
}
?>