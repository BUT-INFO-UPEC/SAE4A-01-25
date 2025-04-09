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
		if ($ana_id != null) return $ana_id;
		
		// On ne peut pas utiliser le create car on ne fournie pas l'id
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
	public function try_delete(Analysis $ana): void {
		// Tant qu'au moins un composant est lié a lanalyse, ne pas la supprimer, si aucun ne lui est lié, la supprimer
		// TODO : if (select from composant where analysis_id == $ana->getId())/lengh == 0 => delete
	}
	public function arrayConstructor(array $objetFormatTableau): Analysis
	{
		return new Analysis($objetFormatTableau["id"],
			(new AttributRepository)->get_attribut_by_id($objetFormatTableau["attribut"]),
			(new AggregationRepository)->get_aggregation_by_id($objetFormatTableau["aggregation"]),
				(new GrouppingRepository)->get_groupping_by_id($objetFormatTableau["groupping"]),
					(new RepresentationRepository)->get_representation_by_id($objetFormatTableau["repr_type"]));
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
