<?php

namespace Src\Model\DataObject;

use Src\Model\DataObject\AbstractDataObject;

class Attribut extends AbstractDataObject
{
	private $id;
	private $type_val;
	private $cle;
	private $nom;
	private $unite;
	private $description;
	private $exemple;

	function __construct($id, $type_val, $cle, $nom, $unite, $description, $exemple)
	{
		$this->id = $id;
		$this->type_val = $type_val;
		$this->cle = $cle;
		$this->nom = $nom;
		$this->unite = $unite;
		$this->description = $description;
		$this->exemple = $exemple;
	}

	function get_id()
	{
		return $this->id;
	}

	function get_type_val()
	{
		return $this->type_val;
	}

	function get_cle()
	{
		return $this->cle;
	}

	function get_nom()
	{
		return $this->nom;
	}

	function get_unite()
	{
		return $this->unite;
	}

	function get_description()
	{
		return $this->description;
	}

	function get_exemple()
	{
		return $this->exemple;
	}

	public function formatTableau(): array
	{
		return [
			":id" => $this->get_id()
		];
	}
}
