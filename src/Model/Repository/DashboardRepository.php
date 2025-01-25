<?php

namespace Src\Model\Repository;

use Src\Model\DataObject\Dashboard;

class DashboardRepository extends AbstractRepository
{
	
	// =======================
	//        ATTRIBUTES
	// =======================
	#region attributes
	const PRIVATISATION = [0 => "publique",1=> "privé"];

	const TYPES_CRITERES_GEO = [0 => "numer_sta"];
	#endregion
	// =======================
	//    PUBLIC METHODS
	// =======================
	#region Publiques

	public function arrayConstructor(array $objetFormatTableau): Dashboard
	{
		$composants = $this->BuildComposants($objetFormatTableau['id']);
		$criteres_geo = $this->BuildGeo($objetFormatTableau['id']);

		return new Dashboard($objetFormatTableau['id'] ,DashboardRepository::PRIVATISATION[$objetFormatTableau['privatisation']] , $objetFormatTableau['createur_id'], $objetFormatTableau['date_debut'] ,$objetFormatTableau['date_fin'] ,$objetFormatTableau['date_debut_relatif'] == "True" ,$objetFormatTableau['date_fin_relatif'] == "True" , $composants, $criteres_geo, $objetFormatTableau['params']);
	}
	
	public function BuildGeo($id): array
	{
		$query = "SELECT type_critere, critere_id FROM CritereGeo_dashboard WHERE dashboard_id = :ID";
		$values = ["ID" => $id];
		$criteres = DatabaseConnection::fetchAll($query, $values); // récupéraiton des criteres géographiques lié a ce dashboard

		$result = [];
		foreach ($criteres as $value) {
			$result[DashboardRepository::TYPES_CRITERES_GEO[$value['type_critere']]][] = $value['critere_id'];
		}

		return $result;
	}

	public function BuildComposants($id): array
	{
		$query = "SELECT composant_id FROM Composant_dashboard WHERE dashboard_id = :ID";
		$values = ["ID" => $id];
		$composantsId = DatabaseConnection::fetchAll($query, $values); // récupéraiton des id des composants du dashboard
		$constructeur = new ComposantRepository();
		$composants = [];
		foreach ($composantsId as $compId) {
			$composants[] = $constructeur->get_composant_by_id($compId['composant_id']);
		}
		return $composants;
	}

	public function getTableName(): string
	{
		return 'Dashboards';
	}

	public function getNomClePrimaire(): string
	{
		return 'id';
	}

	public function getNomsColonnes(): array
	{
		return ['id', 'privatisation', 'createur_id', 'date_debut', 'date_fin', 'date_debut_realtif', 'date_fin_relatif', 'params'];
	}

	public function get_dashboard_by_id(string $id): ?Dashboard
	{
		// ajouter vérif appartenance a l'utilisateur ou visibilité publique ICI

		return $this->select($id);
	}

	public function get_dashboards(): array
	{
		// construire les paramètres where et ajouter des paramètres a mettre dans une liste associative pour filtrer par visibilité entre autre
		return $this->selectAll(null, []);
	}
	#endregion Publiques
	

}
