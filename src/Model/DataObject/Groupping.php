<?php

namespace Src\Model\DataObject;

use Src\Model\DataObject\AbstractDataObject;

class Groupping extends AbstractDataObject
{
	private $id;
	private $nom;
	private $type;
	private $cle;

	function __construct($id, $nom, $type, $cle)
	{
		$this->id = $id;
		$this->nom = $nom;
		$this->type = $type;
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

	function get_type()
	{
		return $this->type;
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
