<?php

namespace Src\Model\Repository;

use Src\Model\Repository\AbstractRequestComponant;
use Src\Model\DataObject\Aggregation;

class AggregationRepository extends AbstractRequestComponant
{
	public function get_aggregation_by_id($id): Aggregation
	{
		return $this->get_object_by_id($id);
	}

	public function get_aggregations(): array
	{
    return $this->get_static_objects_list();
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