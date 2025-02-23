<?php

namespace Src\Model\Repository;

use Exception;
use PDOException;
use Src\Config\MsgRepository;
use Src\Config\SessionManagement;
use Src\Model\DataObject\Dashboard;

class DashboardRepository extends AbstractRepository
{

	// =======================
	//        ATTRIBUTES
	// =======================
	#region attributes

	const TYPES_CRITERES_GEO = [0 => "numer_sta", 1 => "code_epci", 2 => "codegeo", 3 => "code_reg", 4 => "code_dep"];
	const REVERSE_TYPE_GEO = ["numer_sta" => 0, "codegeo" => 2, "code_reg" => 3, "code_dep" => 4];
	#endregion

	#region Publiques
	// =======================
	//    PUBLIC METHODS
	// =======================

	public function arrayConstructor(array $objetFormatTableau): ?Dashboard
	{
		try {
			$composants = $this->BuildComposants($objetFormatTableau['id']);
			$criteres_geo = $this->BuildGeo($objetFormatTableau['id']);

			return new Dashboard($objetFormatTableau['id'], $objetFormatTableau['privatisation'], $objetFormatTableau['createur_id'], $objetFormatTableau['date_debut'], $objetFormatTableau['date_fin'], $objetFormatTableau['date_debut_relatif'] == "True", $objetFormatTableau['date_fin_relatif'] == "True", $composants, $criteres_geo, [$objetFormatTableau['params']]);
		} catch (Exception $e) {
			MsgRepository::newError("Erreur lors de la construction du dashboard", "Le dashboard n'a pas pu être construit.\n" . $e->getMessage());
			return null;
		} catch (PDOException $e) {
			MsgRepository::newError("Erreur lors de la construction du dashboard", "Le dashboard n'a pas pu être construit.\n" . $e->getMessage());
			return null;
		}
	}

	public function BuildGeo($id): array
	{
		try {
			$query = "SELECT type_critere, critere_id FROM CritereGeo_dashboard WHERE dashboard_id = :ID";
			$values = ["ID" => $id];
			$criteres = DatabaseConnection::fetchAll($query, $values); // récupéraiton des criteres géographiques lié a ce dashboard

			$result = [];
			foreach ($criteres as $value) {
				$result[DashboardRepository::TYPES_CRITERES_GEO[$value['type_critere']]][] = $value['critere_id'];
			}

			return $result;
		} catch (Exception $e) {
			MsgRepository::newError("Erreur lors de la récupération des critères géographiques", "Les critères géographiques n'ont pas pu être récupérés.\n" . $e->getMessage());
			return [];
		} catch (PDOException $e) {
			MsgRepository::newError("Erreur lors de la récupération des critères géographiques", "Les critères géographiques n'ont pas pu être récupérés.\n" . $e->getMessage());
			return [];
		}
	}

	public function BuildComposants($id): array
	{
		try {
			$query = "SELECT composant_id FROM Composant_dashboard WHERE dashboard_id = :ID";
			$values = ["ID" => $id];
			$composantsId = DatabaseConnection::fetchAll($query, $values); // récupéraiton des id des composants du dashboard
			$constructeur = new ComposantRepository();
			$composants = [];
			foreach ($composantsId as $compId) {
				$composants[] = $constructeur->get_composant_by_id($compId['composant_id']);
			}
			return $composants;
		} catch (Exception $e) {
			MsgRepository::newError("Erreur lors de la récupération des composants", "Les composants n'ont pas pu être récupérés.\n" . $e->getMessage());
			return [];
		} catch (PDOException $e) {
			MsgRepository::newError("Erreur lors de la récupération des composants", "Les composants n'ont pas pu être récupérés.\n" . $e->getMessage());
			return [];
		}
	}

	public function get_dashboard_by_id(string $id): ?Dashboard
	{
		// ajouter vérif appartenance a l'utilisateur ou visibilité publique
		try {
			$values["createur_id"] = SessionManagement::getUser() == null ? 0 : SessionManagement::getUser()->getId();
			$values["privatisation"] = 0;

			$query = "and (createur_id=:createur_id or privatisation=:privatisation)";

			$dash = $this->select($id, $query, $values);

			return $dash;
		} catch (Exception $e) {
			MsgRepository::newError("Erreur lors de la récupération du dashboard", "Le dashboard n'a pas pu être récupéré.\n" . $e->getMessage());
			return null;
		} catch (PDOException $e) {
			MsgRepository::newError("Erreur lors de la récupération du dashboard", "Le dashboard n'a pas pu être récupéré.\n" . $e->getMessage());
			return null;
		}
	}

	public function get_dashboards($criteres_geo, $order, $dateFilter, $customStartDate, $customEndDate, $privatisation): array
	{
		// construire les paramètres where et ajouter des paramètres a mettre dans une liste associative pour filtrer par visibilité entre autre

		// Déterminer les paramètres (:param => valeur)
		try {
			$values = [];

			// construire les composants de la requette "WHERE"
			$wherequery = [];
			$wherequery[] = $this->buildPrivatisation($values, $privatisation);

			// construire la chaine de caractère de la requette "WHERE" en assamblant ses composants
			$wherequery = "WHERE (" . implode(") and (", $wherequery) . ")";

			// construire la requette "ORDER BY"
			$orderquery = "";

			// combiner la requette entière
			$query = $wherequery . $orderquery;
			return $this->selectAll($query, $values);
		} catch (Exception $e) {
			MsgRepository::newError("Erreur lors de la récupération des dashboards", "Les dashboards n'ont pas pu être récupérés.\n" . $e->getMessage());
			return [];
		} catch (PDOException $e) {
			MsgRepository::newError("Erreur lors de la récupération des dashboards", "Les dashboards n'ont pas pu être récupérés.\n" . $e->getMessage());
			return [];
		}
	}

	public function update_dashboard_by_id(Dashboard $dash)
	{
		try {
			$componantsToDelete = $_SESSION["componants_to_delete"];
			$this->update($dash, $dash->get_id());
			foreach ($dash->get_composants() as $value) {
				// update les différents composants
				(new ComposantRepository)->update($value, $value->get_id());
			}
		} catch (Exception $e) {
			MsgRepository::newError("Erreur lors de la mise à jour du dashboard", "Le dashboard n'a pas pu être mis à jour.\n" . $e->getMessage());
		} catch (PDOException $e) {
			MsgRepository::newError("Erreur lors de la mise à jour du dashboard", "Le dashboard n'a pas pu être mis à jour.\n" . $e->getMessage());
		}
		// suprimer les composants qui ont été unsset
	}

	public function save_new_dashboard(Dashboard $dash)
	{
		try {
			$values = $dash->formatTableau();
			$values[":createur_id"] = SessionManagement::getUser()->getId();
			$values[":id"] = NULL;
			$dashId = (int) $this->create($dash, $values);

			// enregistrer les liens critereGeo
			foreach ($dash->get_region() as $type => $ids) {
				$DB_type = DashboardRepository::REVERSE_TYPE_GEO[$type];
				foreach ($ids as $value) {
					$query = "INSERT INTO CritereGeo_dashboard (dashboard_id, type_critere, critere_id) VALUES (:dashboard_id, :type_critere, :critere_id)";
					$values = [":dashboard_id" => $dashId, ":type_critere" => $DB_type, ":critere_id" => $value];
					DatabaseConnection::executeQuery($query, $values);
				}
			}

			// parcourir les composants et les enregistrés
			foreach ($dash->get_composants() as $comp) {
				$compId = (new ComposantRepository)->save($comp);

				// enregistrer les liens dashboard composants
				$query = "INSERT INTO Composant_dashboard (dashboard_id, composant_id) VALUES (:dashboard_id, :composant_id);";
				$values = [":composant_id" => $compId, ":dashboard_id" => $dashId];
				DatabaseConnection::executeQuery($query, $values);
			}

			return $dashId;
		} catch (Exception $e) {
			MsgRepository::newError("Erreur lors de la sauvegarde du dashboard", "Le dashboard n'a pas pu être sauvegardé.\n" . $e->getMessage());
			return null;
		} catch (PDOException $e) {
			MsgRepository::newError("Erreur lors de la sauvegarde du dashboard", "Le dashboard n'a pas pu être sauvegardé.\n" . $e->getMessage());
			return null;
		}
	}

	public function delete_dashboard(Dashboard $dash): void
	{
		// supprimer le dashboard

		// supprimer les liens géo

		// supprimer les liens avec les composants

		// supprimer les composants
	}
	#endregion Publiques

	#region abstractRepo

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
		return ['id', 'privatisation', 'createur_id', 'date_debut', 'date_fin', 'date_debut_relatif', 'date_fin_relatif', 'params'];
	}
	#endregion abstractRepo

	private function buildPrivatisation(&$values, ?string $privatisation = null)
	{
		try {
			$values[":userId"] = SessionManagement::getUser() == null ? 0 : SessionManagement::getUser()->getId();
			$private_values = ["privatisation = 0", "createur_id = :userId"];
			switch ($privatisation) {
				case 'private':
					unset($private_values[0]);
					break;

				case 'public':
					unset($private_values[1]);
					unset($values[':userId']);
					break;
			}
			return implode(" or ", $private_values);
		} catch (Exception $e) {
			MsgRepository::newError("Erreur lors de la construction de la requête de visibilité", "La requête de visibilité n'a pas pu être construite.\n" . $e->getMessage());
			return "";
		}
	}
}
