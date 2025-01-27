<?php

namespace Src\Model\Repository;

use Src\Model\Repository\AbstractRequestComponant;
use Src\Model\DataObject\Groupping;

class GrouppingRepository extends AbstractRequestComponant
{
	public function get_groupping_by_id($id): Groupping
	{
		return $this->get_object_by_id($id);
	}

	public function get_grouppings(): array
	{
		return $this->get_static_objects_list();
	}
	public  function arrayConstructor(array $objetFormatTableau): Groupping
	{
		return new Groupping($objetFormatTableau["id"], $objetFormatTableau["nom"], $objetFormatTableau["type"], $objetFormatTableau["cle"]);
	}
	public  function getNomClePrimaire(): string
	{
		return "id";
	}
	public  function getNomsColonnes(): array
	{
		return ["id", "nom", "type", "cle"];
	}
	public  function getTableName(): string
	{
		return "Grouppings";
	}
}
