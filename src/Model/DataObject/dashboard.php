<?php

namespace Src\Model\DataObject;

use DateTime;
use Exception;
use OutOfBoundsException;

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


	public function __construct(int $dashboard_id, string $privatisation, int $createurId, $date_debut, $date_fin, bool $date_debut_relatif, bool $date_fin_relatif, array $composants, array $critere_geo, $param)
	{
		$this->dashboardId = $dashboard_id;
		$this->privatisation = $privatisation;
		$this->createurId = $createurId;
		$this->dateDebut = $date_debut;
		$this->dateFin = $date_fin;
		$this->dateDebutRelatif = $date_debut_relatif == '1';
		$this->dateFinRelatif = $date_fin_relatif == '1';
		$this->params = $param;
		$this->selectionGeo = $critere_geo;
		$this->composants = $composants;
	}

	// =======================
	//    PUBLIC GETTERS
	// =======================
	public function get_id()
	{
		return $this->dashboardId;
	}

	public function get_privatisation()
	{
		return $this->privatisation;
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
		throw new OutOfBoundsException("Type de date invalide : utilisez 'debut' ou 'fin'.");
	}

	public function get_params()
	{
		return $this->params;
	}

	public function get_composants(): array
	{
		return $this->composants;
	}

	public function get_params_API_geo(): string
	{
		$returnValue = [];

		foreach ($this->selectionGeo as $key => $value) {
			// Application de la transformation sur chaque élément de $value
			$formattedValues = array_map(function ($valueInValue) use ($key) {
				if ($key == "numer_sta") {
					$valueInValue = str_pad($valueInValue, 5, "0", STR_PAD_LEFT);
					$valueInValue = "'".$valueInValue."'";
				}
				return $valueInValue;
			}, $value);

			// Construction de la chaîne avec implode
			$returnValue[] = "$key=" . implode(" or $key=", $formattedValues);
		}

		return "(" . implode(" and ", $returnValue) . ")";
	}

	public function get_params_API_temporel()
	{
		$dateDebut = $this->dateDebutRelatif ? $this->calculate_relative_date($this->dateDebut) : $this->dateDebut;
		$dateFin = $this->dateFinRelatif ? $this->calculate_relative_date($this->dateFin) : $this->dateFin;

		return "(date >= '$dateDebut" . "T1:00:00+00:00' and date <= '$dateFin" . "T1:00:00+00:00')";
	}

	// =======================
	//    PUBLIC METHODS
	// =======================
	public function formatTableau(): array
	{
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
}
