<?php

namespace Src\Model\Repository;

use Src\Model\Repository\AbstractRepository;
use Src\Model\DataObject\Groupping;

class GrouppingRepository extends AbstractRepository
{
	public function get_groupping_by_id($id): Groupping
	{
		// créer une liste statique (genre PDO) et vérifier sil'attribut est déja initialisé, auquel cas donner l'instance, sinon, instancier
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