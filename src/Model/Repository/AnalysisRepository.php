<?php

namespace Src\Model\Repository;

use Src\Model\DataObject\Analysis;

class AnalysisRepository extends AbstractRequestComponant
{

	public function try_delete(Analysis $ana): void {}
	public function arrayConstructor(array $objetFormatTableau): Analysis
	{
		return new Analysis($objetFormatTableau["id"], $objetFormatTableau["attribut"], $objetFormatTableau["aggregation"], $objetFormatTableau["groupping"], $objetFormatTableau["repr_type"]);
	}
	public  function getNomClePrimaire(): string
	{
		return "id";
	}
	public  function getNomsColonnes(): array
	{
		return ["id", "repr_type", "attribut", "aggregation", "groupping"];
	}
	public  function getTableName(): string
	{
		return "Analyses";
	}
}
