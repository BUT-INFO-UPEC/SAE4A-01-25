<?php

namespace Src\Model\DataObject;

use Src\Model\DataObject\AbstractDataObject;

class Representation extends AbstractDataObject {
	private $id;

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