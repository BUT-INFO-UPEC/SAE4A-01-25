<?php

namespace Src\Model\Repository;

use Src\Model\DataObject\Composant;

class ComposantRepository extends AbstractRepository
{

	public function save(Composant $composant)
	{
		$values = $composant->formatTableau();
		$values[":id"] = null;
		$compId = (int) $this->create($composant, $values);
		return $compId;
	}

	public function MAJ(Composant $composant) {
		$this->update($composant, $composant->get_id());
	}

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
		$params = gettype($objetFormatTableau['params_affich']) == "string" ? $objetFormatTableau['params_affich'] : json_encode($objetFormatTableau['params_affich']);

		return new Composant($att, $aggr, $grp, $repr, $params, $objetFormatTableau['id']);
	}

	public function getNomClePrimaire(): string
	{
		return 'id';
	}

	public function getNomsColonnes(): array
	{
		return ['id', 'repr_type', 'attribut', 'aggregation', 'groupping', 'params_affich'];
	}

	public function getTableName(): string
	{
		return 'Composants';
	}
}
