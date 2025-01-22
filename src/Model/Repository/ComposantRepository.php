<?php

namespace Src\Model\Repository;

use Src\Model\DataObject\Composant;

class ComposantRepository extends AbstractRepository
{
	public function get_composant_by_id($id) {
		return $this->select($id);
	}

	public function arrayConstructor(array $objetFormatTableau): Composant {
		return new Composant($objetFormatTableau['id'], $objetFormatTableau['attribut'], $objetFormatTableau['aggregation'], $objetFormatTableau['groupping'], $objetFormatTableau['repr_type'], $objetFormatTableau['params_affich']);
	}
	public function getNomClePrimaire(): string {
		return 'id';
	}
	public function getNomsColonnes(): array {
		return ['id', 'attribut', 'aggregation', 'groupping', 'repr_type', 'params_affich'];
	}
	public function getTableName(): string {
		return 'Composants';
	}
}