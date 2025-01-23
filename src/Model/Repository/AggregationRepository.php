<?php

namespace Src\Model\Repository;

use Src\Model\Repository\AbstractRepository;
use Src\Model\DataObject\Aggregation;

class AggregationRepository extends AbstractRepository
{
	public function get_aggregation_by_id($id): Aggregation
	{
		// créer une liste statique (genre PDO) et vérifier sil'attribut est déja initialisé, auquel cas donner l'instance, sinon, instancier
		return $this->select($id);
	}
	public  function arrayConstructor(array $objetFormatTableau): Aggregation 
	{
		return new Aggregation($objetFormatTableau["id"], $objetFormatTableau["nom"], $objetFormatTableau["cle"]);
	}
	public  function getNomClePrimaire(): string
	{
		return "id";
	}
	public  function getNomsColonnes(): array
	{
		return ["id", "nom", "cle"];
	}
	public  function getTableName(): string
	{
		return "Aggregations";
	}
}