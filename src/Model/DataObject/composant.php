<?php

namespace Src\Model\DataObject;

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

	public function get_id()
	{
		return $this->id;
	}
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

	public function get_params()
	{
		return $this->params;
	}

	public function get_visu_file(): string
	{
		return $this->repr->get_visu_file();
	}

	public function get_data(Dashboard $dash)
	{
		$params = [];
		$params['where'][] = $dash->get_params_API_geo();
		$params['where'][] = $dash->get_params_API_temporel();
		var_dump(implode(" and ", $params["where"]));
		$params['select'][] = $this->aggregation->get_cle() . "(" . $this->attribut->get_cle() . ")";
		$params["group_by"][] = $this->grouping;

		$data = Requetteur_API::fetchData($params['select'], $params['where'], $params['group_by']);

		var_dump($data);
		// construire la requette a l'API
		return ['total' => '12'];
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
			":repr_type" => $this->repr,
			":attribut" => $this->get_attribut(),
			":aggregation" => $this->get_aggregation(),
			":groupping" => $this->get_grouping(),
			":params_affich" => $this->params
		];
	}
}
