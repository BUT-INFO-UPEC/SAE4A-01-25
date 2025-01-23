<?php

namespace Src\Model\DataObject;

use Src\Model\DataObject\AbstractDataObject;

class Groupping extends AbstractDataObject {
	private $id;

	function __construct($id, $nom, $type, $cle) {
		$this->id = $id;
	}

	function get_id() {
		return $this->id;
	}
	public function formatTableau(): array
	{
		return [
			"id" => $this->get_id()
		];
	}
}