<?php

namespace Src\Model\DataObject;

use Src\Model\DataObject\AbstractDataObject;

class Representation extends AbstractDataObject
{
	private $id;
	private $nom;
	private $grouppings;
	private $fichier_visu;

	function __construct($id, $nom, $grouppings, $fichier_visu)
	{
		$this->id = $id;
		$this->nom = $nom;
		$this->grouppings = $grouppings;
		$this->fichier_visu = $fichier_visu;
	}

	function get_id()
	{
		return $this->id;
	}
	function get_nom()
	{
		return $this->nom;
	}
	function get_grouppings()
	{
		return $this->grouppings;
	}
	function get_visu_file()
	{
		return $this->fichier_visu;
	}
	public function formatTableau(): array
	{
		return [
			":id" => $this->get_id()
		];
	}
}
