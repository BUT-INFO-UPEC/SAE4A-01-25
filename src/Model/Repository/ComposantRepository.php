<?php

namespace Src\Model\Repository;

use Src\Model\DataObject\Composant;

class ComposantRepository extends AbstractRepository
{
	public function get_composant_by_id($id): Composant
	{
		return $this->select($id);
	}

	public function arrayConstructor(array $objetFormatTableau): Composant
	{
		$att = (new AttributRepository)->get_attribut_by_id($objetFormatTableau['attribut']);
		$aggr = (new AggregationRepository)->get_aggregation_by_id($objetFormatTableau['aggregation']);
		$grp = (new GrouppingRepository)->get_groupping_by_id($objetFormatTableau['groupping']);
		$repr = (new RepresentationRepository())->get_representation_by_id($objetFormatTableau['repr_type']);

		return new Composant($objetFormatTableau['id'], $att, $aggr, $grp, $repr, $objetFormatTableau['params_affich']);
	}

	public function getNomClePrimaire(): string
	{
		return 'id';
	}

	public function getNomsColonnes(): array
	{
		return ['id', 'attribut', 'aggregation', 'groupping', 'repr_type', 'params_affich'];
	}

	public function getTableName(): string
	{
		return 'Composants';
	}
}
