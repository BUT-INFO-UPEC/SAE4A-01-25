<?php

namespace Src\Model\DataObject;

use DateTime;
use Exception;
use Src\Model\Repository\Requetteur_API;
use Src\Model\Repository\Requetteur_BDD;

class Dashboard
{
  // =======================
  //        ATTRIBUTES
  // =======================
  private $dashboardId;
  private $privatisation;
  private $composants = [];
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

    // Filtre des données à analyser
    $this->dateDebut = $data->date_debut;
    $this->dateFin = $data->date_fin;
    $this->dateDebutRelatif = $data->date_debut_relatif == '1';
    $this->dateFinRelatif = $data->date_fin_relatif == '1';
    $this->selectionGeo = $data->selection_geo;

    // Construction des composants du dashboard
    foreach (json_decode($data->composant_list) as $compId) {
      $this->composants[] = new Composant($compId);
    }

    $this->params = $data->param;
  }

  // =======================
  //    PUBLIC GETTERS
  // =======================
  public function get_id()
  {
    return $this->dashboardId;
  }

  /**
   * Crée une structure de données qui contient les filtres des stations à interroger
   * 
   * @return array Tableau contenant les dates de début et de fin finales de l'encadrement temporel ainsi que la liste des stations à interroger
   */
  public function get_filters()
  {
    // Construction de la date de début si elle est dynamique
    $dateDebut = $this->dateDebutRelatif ? $this->calculate_relative_date($this->dateDebut) : $this->dateDebut;

    // Construction de la date de fin si elle est dynamique
    $dateFin = $this->dateFinRelatif ? $this->calculate_relative_date($this->dateFin) : $this->dateFin;

    // Encapsulation dans une structure de données
    return [
      "dateDebut" => $dateDebut,
      "dateFin" => $dateFin,
      "geo" => get_object_vars($this->selectionGeo)
    ];
  }

  public function get_name()
  {
    return $this->params;
  }

  // =======================
  //    PUBLIC METHODS
  // =======================
  /**
   * Récupère les données pour chaque composant et génère les visualisations
   * 
   * @return string Structure HTML compilant la visualisation des données de chacun des composants du dashboard
   */
  public function generate_dashboard()
  {
    $output = "<div id='dashboard'>";
    foreach ($this->composants as $composant) {
      $data = $this->fetch_data_for_composant($composant);
      $output .= "<div class='dashboard-card'>" . $composant->generate_visual($data) . "</div>";
    }
    $output .= "</div>";
    return $output;
  }

  /**
   * Exporte et sauvegarde le dashboard dans la BDD
   * 
   * @param bool $override Indique si l'utilisateur veut écraser l'ancienne version de son Dashboard
   * 
   * @throws Exception Si le dashboard existe déjà et que l'utilisateur n'a pas confirmé l'écrasement
   */
  public function save_dashboard($override)
  {
    // Vérifier l'appartenance
    if ($this->createurId == $_SESSION['userId']) {
      // Générer un nouvel ID pour le dashboard
      // $this->dashboardId = Requetteur_BDD::generate_dash_id($this->dashboardId);
    } elseif ($override && Requetteur_BDD::is_saved_dashboard($this->dashboardId)) {
      // Lever une exception pour demander confirmation d'écrasement
      throw new Exception("Tentative de sauvegarder un dashboard déjà existant.", 301);
    }

    // Sauvegarde/exportation du dashboard
  }

  // =======================
  //    STATIC METHODS
  // =======================
  /**
   * Récupère un dashboard dans la BDD_ grâce à son ID
   * 
   * @param string $dashboardId L'ID du dashboard
   * 
   * @return Dashboard L'objet correspondant à la ligne de la BDD
   */
  static function get_dashboard_by_id($dashboardId)
  {
    $data = Requetteur_BDD::BDD_fetch_dashboards()[$dashboardId];
    return new Dashboard($data);
  }

  /**
   * Récupère tous les dashboards de la BDD
   * 
   * @return array Liste des dashboards de la BDD
   */
  static function get_dashboards()
  {
    $r = [];
    foreach (Requetteur_BDD::BDD_fetch_dashboards() as $dash_data) {
      $r[] = new Dashboard($dash_data);
    }
    return $r;
  }

  // =======================
  //    PRIVATE METHODS
  // =======================
  /**
   * Calcule une date relative à partir de la date actuelle
   * 
   * @param string $relativeDate Date au format AAAA-MM-JJ
   * 
   * @return string Date calculée au format "Y-m-d\TH:i:s"
   */
  private function calculate_relative_date($relativeDate)
  {
    $annee = (int)substr($relativeDate, 0, 4);
    $mois = (int)substr($relativeDate, 5, 2);
    $jours = (int)substr($relativeDate, 8, 2);

    $date = new DateTime();
    if ($annee > 0) $date->modify("-$annee year");
    if ($mois > 0) $date->modify("-$mois month");
    if ($jours > 0) $date->modify("-$jours day");

    return $date->format("Y-m-d") . "T00:00:00";
  }

  /**
   * Récupère les données via l'API pour un composant donné
   * 
   * @param Composant $composant L'objet dont les données doivent être récupérées
   * 
   * @return array Liste des données selon les critères spécifiés
   */
  private function fetch_data_for_composant($composant)
  {
    $attribute = $composant->get_attribut();
    $aggregation = $composant->get_aggregation();
    $grouping = $composant->get_grouping();
    $filtres = $this->get_filters();
    return Requetteur_API::API_componant_data($filtres, $attribute, $aggregation, $grouping);
  }
}
