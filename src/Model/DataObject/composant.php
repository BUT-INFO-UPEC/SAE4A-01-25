<?php

namespace Src\Model\DataObject;

use Src\Model\Repository\RequettesBDD;

class Composant extends AbstractDataObject
{
	// =======================
	//        ATTRIBUTES
	// =======================
	private $id;
	private $composantId;
	private $attribut;
	private $aggregation;
	private $grouping;
	private $repr;
	private $params;

	// =======================
	//      CONSTRUCTOR
	// =======================
	public function __construct($composant_id, $attribut, $aggregation, $grouping, $repr_type, $param_affich)
	{
		$this->composantId = $composant_id;
		$this->attribut = $attribut;
		$this->aggregation = $aggregation;
		$this->grouping = $grouping;
		$this->set_repr($repr_type);
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
		return $this->repr;
	}

	public function get_data()
	{
		// construire la requette a l'API
		return ['total' => '12'];
	}

	// =======================
	//      SETTERS
	// =======================
	public function set_repr($reprId)
	{
		// Récupérer les détails de la représentation
		$this->repr = RequettesBDD::getRepresentations($reprId);
	}

	// =======================
	//    PUBLIC METHODS
	// =======================
	public function formatTableau(): array
	{
		return [
			"id" => $this->get_id(),
			"repr_type" => $this->repr,
			"attribut" => $this->get_attribut(),
			"aggregation" => $this->get_aggregation(),
			"groupping" => $this->get_grouping(),
			"params_affich" => $this->params
		];
	}
}
