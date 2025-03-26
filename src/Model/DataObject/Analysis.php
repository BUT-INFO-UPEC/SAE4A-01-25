<?php

namespace Src\Model\DataObject;

use Src\Model\DataObject\AbstractDataObject;

class Analysis extends AbstractDataObject {

	public function formatTableau(): array
	{
		return [
			":id" => 0
		];
	}
}