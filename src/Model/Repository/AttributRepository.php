<?php

namespace Src\Model\Repository;

use Src\Model\Repository\AbstractRepository;
use Src\Model\DataObject\Attribut;

class AttributRepository extends AbstractRepository
{
	public function get_attribut_by_id($id): Attribut
	{
		// créer une liste statique (genre PDO) et vérifier sil'attribut est déja initialisé, auquel cas donner l'instance, sinon, instancier
		return $this->select($id);
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