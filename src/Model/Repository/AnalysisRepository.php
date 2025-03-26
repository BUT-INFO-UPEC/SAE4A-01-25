<?php

namespace Src\Model\Repository;

use Src\Model\DataObject\Analysis;

class AnalysisRepository extends AbstractRequestComponant {

	public function arrayConstructor(array $objetFormatTableau): Analysis
	{
		return new Analysis($objetFormatTableau["id"], $objetFormatTableau["nom"], $objetFormatTableau["cle"]);
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