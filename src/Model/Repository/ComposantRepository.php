<?php

namespace Src\Model\Repository;

use Src\Model\DataObject\Composant;
use Src\Config\ServerConf\DatabaseConnection;

class ComposantRepository extends AbstractRepository
{

	public function save_new(Composant $composant, int $dashId)
	{
		$values = $composant->formatTableau();
		$values[":id"] = null;
		$compId = (int) $this->create($composant, $values);

		// enregistrer les liens dashboard composants
		$query = "INSERT INTO Composant_dashboard (dashboard_id, composant_id) VALUES (:dashboard_id, :composant_id);";
		$values = [":composant_id" => $compId, ":dashboard_id" => $dashId];
		DatabaseConnection::executeQuery($query, $values);

		return $compId;
	}

	public function update_or_create_comp(Composant $composant, int $dashId): int|null
	{
		if ($composant->get_id() != null) { // Si le composant existe, le mettre a jour
			$this->update($composant, $composant->get_id());
			return null;
		} else { // ajouter le composant a la BDD et récupérer l'ID
			return $this->save_new($composant, $dashId);
		}
	}

	public function get_composant_by_id($id): Composant
	{
		return $this->select($id);
	}

	public function try_delete(Composant $comp) {
		$this->delete($comp->get_id());
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
