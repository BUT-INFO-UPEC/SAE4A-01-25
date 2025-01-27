<?php

namespace Src\Model\DataObject;

use Src\Config\MsgRepository;
use Src\Model\API\Constructeur_Requette_API;
use Src\Model\API\Requetteur_API;

class Composant extends AbstractDataObject
{
	// =======================
	//        ATTRIBUTES
	// =======================
	private $id;
	private Attribut $attribut;
	private Aggregation $aggregation;
	private Groupping $grouping;
	private Representation $repr;
	private $params;
	private $data;

	// =======================
	//      CONSTRUCTOR
	// =======================
	public function __construct($composant_id, $attribut, $aggregation, $grouping, $repr_type, $param_affich)
	{
		$this->id = $composant_id;
		$this->id = $composant_id;
		$this->attribut = $attribut;
		$this->aggregation = $aggregation;
		$this->grouping = $grouping;
		$this->repr = $repr_type;
		$this->params = json_decode($param_affich, true);
	}

	// =======================
	//      GETTERS
	// =======================

	public function get_id(): int
	{
		return $this->id;
	}
	public function get_attribut(): Attribut
	{
		return $this->attribut;
	}

	public function get_aggregation(): Aggregation
	{
		return $this->aggregation;
	}

	public function get_grouping(): Groupping
	{
		return $this->grouping;
	}

	public function get_params()
	{
		return $this->params;
	}

	public function get_visu_file(): string
	{
		return $this->repr->get_visu_file();
	}

	// =======================
	//      SETTERS
	// =======================

	// =======================
	//    PUBLIC METHODS
	// =======================
	public function formatTableau(): array
	{
		return [
			":id" => $this->get_id(),
			":repr_type" => $this->repr->get_id(),
			":attribut" => $this->get_attribut()->get_id(),
			":aggregation" => $this->get_aggregation()->get_id(),
			":groupping" => $this->get_grouping()->get_id(),
			":params_affich" => $this->params ?? ""
		];
	}

	public function prepare_data(Dashboard $dash)
	{
		$params = [];

		$geo = $dash->get_params_API_geo();
		if ($geo) $params["where"][] = $geo;

		$params['where'][] = $dash->get_params_API_temporel();

		$keyTargetValue = $this->aggregation->get_nom() . " " . $this->attribut->get_nom();

		// var_dump(implode(" and ", $params["where"]));
		$params['select'][] = $this->aggregation->get_cle() . "(" . $this->attribut->get_cle() . ") as " . $this->nettoyer_chaine($keyTargetValue);

		$params["group_by"][] = $this->grouping->get_cle();

		$keyValueSort = !empty($params["group_by"]) ? $params["group_by"][0] : "";

		$requette = new Constructeur_Requette_API($params['select'], $params['where'], $params['group_by']);

		MsgRepository::newWarning($requette->formatUrl(), "", MsgRepository::NO_REDIRECT);

		// construire la requette a l'API
		$data = Requetteur_API::fetchData($requette, $keyValueSort, $keyTargetValue);

		var_dump($data);
		$this->data = ['total' => '12'];
	}

	public function get_data(Dashboard $dash)
	{
		if (isset($this->data)) return $this->data;
		$this->prepare_data($dash);
	}

	private function nettoyer_chaine($chaine)
	{
		// Remplacement des caractères accentués
		$chaine = iconv('UTF-8', 'ASCII//TRANSLIT', $chaine);

		// Remplacement des espaces par des underscores
		$chaine = str_replace(' ', '_', $chaine);

		// Suppression des caractères non alphanumériques (hors "_")
		$chaine = preg_replace('/[^a-zA-Z0-9_]/', '', $chaine);

		return $chaine;
	}
}
