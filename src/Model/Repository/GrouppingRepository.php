<?php

namespace Src\Model\Repository;

use Src\Model\Repository\AbstractRepository;
use Src\Model\DataObject\Groupping;

class GrouppingRepository extends AbstractRepository
{
	public function get_groupping_by_id($id): Groupping
	{
		return $this->select($id);
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