<?php

namespace Src\Model\Repository;

use Src\Model\Repository\AbstractRequestComponant;
use Src\Model\DataObject\Attribut;

class AttributRepository extends AbstractRequestComponant
{
	public function get_attribut_by_id($id): Attribut
	{
		return $this->get_object_by_id($id);
	}

	public function get_attributs(): array
	{
		return $this->get_static_objects_list();
	}

	public  function arrayConstructor(array $objetFormatTableau): Attribut
	{
		return new Attribut($objetFormatTableau["id"], $objetFormatTableau["value_type"], $objetFormatTableau["key"], $objetFormatTableau["name"], $objetFormatTableau["unit"], $objetFormatTableau["description"], $objetFormatTableau["example"]);
	}
	public  function getNomClePrimaire(): string
	{
		return "id";
	}
	public  function getNomsColonnes(): array
	{
		return ["id", "value_type", "key", "name", "unit", "description", "example"];
	}
	public  function getTableName(): string
	{
		return "Attributs";
	}
}
