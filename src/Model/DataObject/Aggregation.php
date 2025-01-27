<?php

namespace Src\Model\DataObject;

use Src\Model\DataObject\AbstractDataObject;

class Aggregation extends AbstractDataObject
{
	private $id;
	private $nom;
	private $cle;

	function __construct($id, $nom, $cle)
	{
		$this->id = $id;
		$this->nom = $nom;
		$this->cle = $cle;
	}

	function get_id()
	{
		return $this->id;
	}

	function get_nom()
	{
		return $this->nom;
	}

	function get_cle()
	{
		return $this->cle;
	}

	public function formatTableau(): array
	{
		return [
			":id" => $this->get_id()
		];
	}
}
