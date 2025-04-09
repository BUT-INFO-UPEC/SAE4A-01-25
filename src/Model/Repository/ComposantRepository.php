<?php

namespace Src\Model\Repository;

use Src\Model\DataObject\Composant;

class ComposantRepository extends AbstractRepository
{
	public function save_new(Composant $composant, int $dashId)
	{
		// s'assurer que l'analyse est définie
		$ana = $composant->get_analysis();
		(new AnalysisRepository)->try_create($ana);

		$values = $composant->formatTableau();
		$values[":id"] = null;
		$values[":dashboard_id"] = $dashId;
		$compId = (int) $this->create($composant, $values);

		return $compId;
	}

	public function update_comp(Composant $composant, int $dashId): int|null
	{
		if ($composant->get_id() != null) { // Si le composant existe, le mettre a jour
			(new AnalysisRepository)->try_create($composant->get_analysis());
			$this->update($composant, $composant->get_id());
			return $composant->get_id();
		} else { // ajouter le composant a la BDD et récupérer l'ID
			return $this->save_new($composant, $dashId);
		}
	}

	public function get_composant_by_id($id): Composant
	{
		return $this->select($id);
	}
	
	public function get_composants_from_dashboard($dash_id): array
	{
		try {
			$querry = "WHERE dashboard_id = :dash_id";
			$values[":dash_id"] = $dash_id;
			return $this->selectAll($querry, $values);
		} catch (\Throwable $th) {
			throw $th;
		}
	}

	public function try_delete(Composant $comp)
	{
		$this->delete($comp->get_id());

		// supprimer l'analyse su elle n'est plus utilisée
		(new AnalysisRepository)->try_delete($comp->get_analysis());
	}

	public function arrayConstructor(array $objetFormatTableau): Composant
	{
		$params = gettype($objetFormatTableau['params_affich']) == "string" ? $objetFormatTableau['params_affich'] : json_encode($objetFormatTableau['params_affich']);
		$analisis = (new AnalysisRepository)->get_object_by_id($objetFormatTableau["analysis_id"]);
		return new Composant($analisis, json_decode($params, true), $objetFormatTableau['id']);
	}

	public function getNomClePrimaire(): string
	{
		return 'id';
	}

	public function getNomsColonnes(): array
	{
		return ['id', 'analysis_id', 'params_affich', 'dashboard_id'];
	}

	public function getTableName(): string
	{
		return 'Composants';
	}
}
