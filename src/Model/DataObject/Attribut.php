<?php

namespace Src\Model\DataObject;

use Src\Model\DataObject\AbstractDataObject;

class Attribut extends AbstractDataObject
{
	private $id;

	function __construct($id, $type_val, $cle, $nom, $unite, $description, $exemple)
	{
		$this->id = $id;
	}

	function get_id()
	{
		return $this->id;
	}
	public function formatTableau(): array
	{
		return [
			"id" => $this->get_id()
		];
	}
}
