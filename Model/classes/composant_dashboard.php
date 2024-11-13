<?php

require_once 'requetteur_BDD.php';

class Composant
{
    // =======================
    //        ATTRIBUTES
    // =======================
    private $composantId;
    private $attribut;
    private $aggregation;
    private $grouping;
    private $reprId;
    private $repr;
    private $params;

    // =======================
    //      CONSTRUCTOR
    // =======================
    public function __construct($composantId)
    {
        BDD_fetch_component($this, $composantId);
    }

    // =======================
    //      GETTERS
    // =======================
    public function getAttribut()
    {
        return $this->attribut;
    }

    public function getAggregation()
    {
        return $this->aggregation;
    }

    public function getGrouping()
    {
        return $this->grouping;
    }

    // =======================
    //      SETTERS
    // =======================
    public function set_repr($reprId)
    {
        $this->reprId = $reprId;
        // Récupérer les détails de la représentation
        $this->repr = BDD_fetch_visualisation($reprId);
    }

    // =======================
    //    PUBLIC METHODS
    // =======================
    /** 
     * Méthode pour générer la représentation visuelle
     * 
     * @param array $data La liste des données a mettre en forme
     * @return string Chaine de caractère permétant de représenter les données selon la visualisation parametrée de l'objet
     */
    public function generate_visual($data)
    {

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
            return "<p>Representation non suportée</p>";
        }
    }
}
