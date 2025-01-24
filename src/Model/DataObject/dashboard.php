<?php

namespace Src\Model\DataObject;

use DateTime;
use Exception;
use Src\Model\Repository\Requetteur_API;
use Src\Model\DataObject\Composant;

class Dashboard extends AbstractDataObject
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


	public function __construct($dashboard_id, $privatisation, $createurId, $date_debut, $date_fin, $date_debut_relatif, $date_fin_relatif, $param, $RepositoryConstructor)
	{
		$this->dashboardId = $dashboard_id;
		$this->privatisation = $privatisation;
		$this->createurId = $createurId;
		$this->dateDebut = $date_debut;
		$this->dateFin = $date_fin;
		$this->dateDebutRelatif = $date_debut_relatif == '1';
		$this->dateFinRelatif = $date_fin_relatif == '1';
		$this->params = $param;


		$this->selectionGeo = $RepositoryConstructor->BuildGeo($dashboard_id);

		$this->composants = $RepositoryConstructor->BuildComposants($dashboard_id);
	}

	// =======================
	//    PUBLIC GETTERS
	// =======================
	public function get_id()
	{
		return $this->dashboardId;
	}

	public function get_privatisation() {
		return $this->privatisation;
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

	public function get_params() {
		return $this->params;
	}

	public function get_composants():array {
		return $this->composants;
	}

	public function get_() {
		
	}

	// =======================
	//    PUBLIC METHODS
	// =======================
	public function formatTableau(): array {
    return [
      "id" => $this->get_id(),
			"privatisation" => $this->get_privatisation(),
      "date_debut" => $this->get_date('debut'),
      "date_fin" => $this->get_date('fin'),
      "date_debut_relatif" => $this->dateDebutRelatif,
      "date_fin_relatif" => $this->dateDebutRelatif,
      "params" => $this->get_name()
		];     
  }

	// =======================
	//    STATIC METHODS
	// =======================

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
