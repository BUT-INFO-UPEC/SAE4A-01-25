<?php

namespace Src\Model\Repository;

use Src\Config\ServerConf\DatabaseConnection;
use Src\Config\Utils\MsgRepository;
use Src\Config\Utils\SessionManagement;
use Src\Model\DataObject\Analysis;

class AnalysisRepository extends AbstractRequestComponant
{

	public function try_create(Analysis $ana): int
	{
		$ana_id = $ana->getId();
		if ($ana_id) return $ana_id;
		$querry = "INSERT INTO Analyses (repr_type, attribut, aggregation, groupping) VALUES
           (:repr_type, :attribut, :aggregation, :groupping)
          ON CONFLICT(repr_type, attribut, aggregation, groupping) DO NOTHING
          RETURNING id;";
		$params[":repr_type"] = $ana->getRepresentation()->get_id();
		$params[":attribut"] = $ana->getAttribut()->get_id();
		$params[":aggregation"] = $ana->getAggregation()->get_id();
		$params[":groupping"] = $ana->getGroupping()->get_id();
		$return = DatabaseConnection::fetchOne($querry, $params);

		if (!$return) { // Si l'insertion a été ignorée, on récupère l'ID existant
			$query = "SELECT id FROM Analyses 
                  WHERE repr_type = :repr_type 
                  AND attribut = :attribut 
                  AND aggregation = :aggregation 
                  AND groupping = :groupping;";
			$return = DatabaseConnection::fetchOne($query, $params);
		}
		$ana_id = $return["id"];

		$ana->setId($ana_id);
		return $ana_id;
	}
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
