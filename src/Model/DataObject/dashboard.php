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
    $this->dateDebut = $data->date_debut;
    $this->dateFin = $data->date_fin;
    $this->dateDebutRelatif = $data->date_debut_relatif == '1';
    $this->dateFinRelatif = $data->date_fin_relatif == '1';
    $this->selectionGeo = $data->selection_geo;

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

  public function get_filters()
  {
    $dateDebut = $this->dateDebutRelatif ? $this->calculate_relative_date($this->dateDebut) : $this->dateDebut;
    $dateFin = $this->dateFinRelatif ? $this->calculate_relative_date($this->dateFin) : $this->dateFin;

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
  public function get_region()
  {
    return $this->selectionGeo;
  }


  /**
   * Retourne la date de début ou de fin
   * 
   * @param string $type 'debut' pour la date de début, 'fin' pour la date de fin
   * 
   * @return string La date correspondante
   * 
   * @throws Exception Si le type est invalide
   */
  public function get_date($type = 'debut')
  {
    if ($type === 'debut') {
      return $this->dateDebut;
    } elseif ($type === 'fin') {
      return $this->dateFin;
    }
    throw new Exception("Type de date invalide : utilisez 'debut' ou 'fin'.");
  }

  // =======================
  //    PUBLIC METHODS
  // =======================
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

  public function save_dashboard($override)
  {
    if ($this->createurId == $_SESSION['userId']) {
      // Générer un nouvel ID pour le dashboard
      // $this->dashboardId = Requetteur_BDD::generate_dash_id($this->dashboardId);
    } elseif ($override && Requetteur_BDD::is_saved_dashboard($this->dashboardId)) {
      throw new Exception("Tentative de sauvegarder un dashboard déjà existant.", 301);
    }
  }

  // =======================
  //    STATIC METHODS
  // =======================
  static function get_dashboard_by_id($dashboardId)
  {
    $data = Requetteur_BDD::BDD_fetch_dashboards()[$dashboardId];
    return new Dashboard($data);
  }

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

  private function fetch_data_for_composant($composant)
  {
    $attribute = $composant->get_attribut();
    $aggregation = $composant->get_aggregation();
    $grouping = $composant->get_grouping();
    $filtres = $this->get_filters();
    return Requetteur_API::API_componant_data($filtres, $attribute, $aggregation, $grouping);
  }
}



