<?php

namespace Src\Model\DataObject;

use Src\Model\DataObject\AbstractDataObject;

class Representation extends AbstractDataObject
{
	private $id;
	private $fichier_visu;

	function __construct($id, $nom, $grouppings, $fichier_visu)
	{
		$this->id = $id;
		$this->fichier_visu = $fichier_visu;
	}

	function get_id()
	{
		return $this->id;
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
