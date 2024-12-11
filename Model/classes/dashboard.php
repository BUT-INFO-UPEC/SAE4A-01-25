<?php
require_once __DIR__ . '/../requetteurs/requetteur_BDD.php';
require_once __DIR__ . '/../requetteurs/requetteur_API.php';
require_once __DIR__ . '/Composant.php';

class Dashboard
{
    // =======================
    //        ATTRIBUTES
    // =======================
    private $dashboardId;
    private $privatisation;
    private $composants = array();
    private $createurId;
    private $dateDebut;
    private $dateFin;
    public $dateDebutRelatif;
    public $dateFinRelatif;
    private $selectionGeo;
    private $params;

    // =======================
    //      CONSTRUCTOR
    // =======================
    public function __construct($data)
    {
        $this->dashboardId = $data->dashboard_id;

        // filtre des données a analisées
        $this->dateDebut = $data->date_debut;
        $this->dateFin = $data->date_fin;
        $this->dateDebutRelatif = $data->date_debut_relatif == '1';
        $this->dateFinRelatif = $data->date_fin_relatif == '1';
        $this->selectionGeo = $data->selection_geo;

        // construction des composants du dashboard
        foreach (json_decode($data->composant_list) as $compId){
            if (isset($tab[0])) {
                array_push($this->composants, new Composant($compId));
            } else {
                $this->composants[0] = new Composant($compId);
            }
        }

        $this->params = $data->param;
    }

    // =======================
    //    PUBLIC GETTERS
    // =======================
    public function get_id() {
        return $this->dashboardId;
    }

    /**
     * Créer une structure de donnée qui contient les filtres des stations a intéroger
     * 
     * @return mixed Tableau contenant les dates de début et de fin finales de l'encadremant temporel ainsi que la liste des sations a intérogées
     */
    public function get_filters() {
        // construction de la date de début si elle est dinamique
        if ($this->dateDebutRelatif) {
            // Extraire les années, mois et jours du laps de temps
            $annee = (int)substr($this->dateDebut, 0, 4);
            $mois = (int)substr($this->dateDebut, 5, 2);
            $jours = (int)substr($this->dateDebut, 8, 2);

            // Obtenir la date d'aujourd'hui en tant qu'objet DateTime
            $date = new DateTime();

            // Soustraire les années, mois et jours de la date
            if ($annee > 0) $date->modify("-$annee year");
            if ($mois > 0) $date->modify("-$mois month");
            if ($jours > 0) $date->modify("-$jours day");

            $dateDebut = $date->format("Y-m-d")."T00:00:00";
        } else {
            $dateDebut =$this->dateDebut;
        }

        // construction de la fin de début si elle est dinamique
        if ($this->dateFinRelatif) {
            // Extraire les années, mois et jours du laps de temps
            $annee = (int)substr($this->dateFin, 0, 4);
            $mois = (int)substr($this->dateFin, 5, 2);
            $jours = (int)substr($this->dateFin, 8, 2);

            // Obtenir la date d'aujourd'hui en tant qu'objet DateTime
            $date = new DateTime();
            
            // Soustraire les années, mois et jours de la date
            if ($annee > 0) $date->modify("-$annee year");
            if ($mois > 0) $date->modify("-$mois month");
            if ($jours > 0) $date->modify("-$jours day");

            $dateFin = $date->format("Y-m-d")."T00:00:00";
        } else {
            $dateFin =$this->dateFin;
        }


        // encapsulation dans une structure de données qui sera interprétée par le constructeur de requettes API
        $filtres = [
            "dateDebut" => $dateDebut,
            "dateFin" => $dateFin,
            "geo" => get_object_vars($this->selectionGeo)
        ];
        return $filtres;
    }

    public function get_name() {
        return $this->params;
    }

    // =======================
    //    PUBLIC METHODS
    // =======================
    /**
     * Récupérer les données pour chaque composant et générer les visualisations
     * 
     * @return string la chaine de caractères (structure HTML) compilant la visualisation des données de chacuns des composants du dashboard
     */
    public function generate_dashboard()
    {
        $output = "<div id='dashboard'>";
        foreach ($this->composants as $composant) {
            $data = $this->fetch_data_for_componant($composant);
            $output .= "<div class='dashboard-card'>".$composant->generate_visual($data)."</div>";
        }
        $output .= "</div>";
        return $output;
    }

    /**
     * Exporte et sauvegarde le dashboard dans la BDD
     * 
     * @param bool $override L'utilisateur veut écraser l'ancienne version de son Dashboard
     * 
     * @throw DashboardDejaExistant Soulève une exception si le dashboard existe déja pour confirmation de l'écrasement
     */
    public function save_dashboard($override)
    {
        // Vérifier l'appartenance
        if ($this->createurId == get_session_user_id()) {
            // générer un nouvel id et ajouter une ligne dans suivi_copiright
            $this->dashboardId = generate_dash_id($this->dashboardId);
        } elseif ($override && is_saved_dashboard($this->dashboardId)) {
            // lever une exception pour affichier un message a l'utilisateur pour lui demander confirmation de l'écrasement du dashboard enregistré, et donc everride, si il veut faire une copie auquel cas, lui générer un nouveau id (generate_dash_id()) ou si il veut annuler
            throw new Exception("Tentative de sauvegarder un dashboard déja existant.", 301);
        }

        //exporter/sauvegarder
    }

    // =======================
    //    STATIC METHODS
    // =======================
    /**
     * Récupère un dashboard dans la BDD grace a son ID
     * 
     * @return Dashboard l'objet correspondant a la ligne de la BDD
     */
    static function get_dashboard_by_id($dashboardId) {
        $data = BDD_fetch_dashboards()[$dashboardId];
        return new Dashboard($data);
    }

    /**
     * FONCTION TEMPORAIRE - Récupère tout les dashboards de la BDD
     * 
     * plus tard, surement passage des paramètres de filtre pour créer les listes de recherche (liste_dashboard.php)
     * 
     * @return array liste des dashboards de la BDD
     */
    static function get_dashboards() {
        $r = [];
        foreach (BDD_fetch_dashboards() as $dash_data) {
            array_push($r, new Dashboard($dash_data));
        }
        return $r;
    }

    // =======================
    //    PRIVATE METHODS
    // =======================
    /** 
     * Récupération des données via l'API 
     * 
     * @param Composant $composant L'objet dont les données doivent etres récupérées
     * 
     * @return array La liste des données selon les critères spécifiés
     */
    private function fetch_data_for_componant($composant)
    {
        $attribute = $composant->get_attribut();
        $aggregation = $composant->get_aggregation();
        $grouping = $composant->get_grouping();
        $filtres = $this->get_filters();
        return API_componant_data($filtres, $attribute, $aggregation, $grouping);
    }
}
