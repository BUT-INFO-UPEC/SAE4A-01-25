<?php

require_once __DIR__ . '/../requetteurs/requetteur_BDD.php';

class Composant
{
    // =======================
    //        ATTRIBUTES
    // =======================
    private $composantId;
    private $attribut;
    private $aggregation;
    private $grouping;
    private $repr;
    private $params;

    // =======================
    //      CONSTRUCTOR
    // =======================
    public function __construct($composantId)
    {
        $data = BDD_fetch_component($composantId);
        $this->composantId = $data->composant_id;
        $this->attribut = $data->attribut;
        $this->aggregation = $data->aggregation;
        $this->grouping = $data->grouping;
        $this->set_repr($data->repr_type);
        $this->params = $data->param_affich;
    }

    // =======================
    //      GETTERS
    // =======================
    public function get_attribut()
    {
        return $this->attribut;
    }

    public function get_aggregation()
    {
        return $this->aggregation;
    }

    public function get_grouping()
    {
        return $this->grouping;
    }

    // =======================
    //      SETTERS
    // =======================
    public function set_repr($reprId)
    {
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
        foreach ($this->repr["import_files"] as $import) {
            require_once __DIR__ . "/../visualisations/".$import;
        }

        $formateur = $this->repr["data_formateur"];

        if (function_exists($formateur)) {
            // Appeler dynamiquement la fonction
            $donneesFormatees = call_user_func($formateur, $data);
        } else {
            $donneesFormatees = $data;
            echo "<p>pas de formateur</p>";
        }

        // Récupérer le nom de la fonction
        $constructor = $this->repr['visualisation_constructor'];
        echo "<p>$constructor</p>";

        if (function_exists($constructor)) {
            // Appeler dynamiquement la fonction
            return call_user_func($constructor, $donneesFormatees, $this->params);
        } else {
            return "<p>Representation non suportée</p>";
        }
    }
}
