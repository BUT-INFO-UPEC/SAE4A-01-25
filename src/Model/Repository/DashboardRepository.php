<?php

namespace Src\Model\Repository;

use Exception;
use PDOException;
use Src\Config\Utils\LogInstance;
use Src\Config\Utils\MsgRepository;
use Src\Config\Utils\SessionManagement;
use Src\Config\ServerConf\DatabaseConnection;
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
		SessionManagement::get_curent_log_instance()->new_log("Instanciation du dashboard " . $objetFormatTableau['id']);
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
			foreach ($composantsId as $index => $compId) {
				SessionManagement::get_curent_log_instance()->new_log("Instanciation du composant " . $index + 1 . "/" . count($composantsId));
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
			$values["createur_id"] = SessionManagement::getUser() == null;
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

	public function update_dashboard(Dashboard $dash)
	{
		SessionManagement::get_curent_log_instance()->new_log("Mise a jour du dashboard dans la BDD...");
		try {
			$this->update($dash, $dash->get_id());
			$dashId = $dash->get_id();

			$comp_repo = new ComposantRepository;
			$new_comp_id_to_link = [];
			// créer ou modifier les composants dans la BDD
			foreach ($dash->get_composants() as $index => $comp) {
				SessionManagement::get_curent_log_instance()->new_log("Mise a jour du composant " . $comp->get_id() . " : " . $index + 1 . "/" . count($dash->get_composants()));
				$comp_repo->update_or_create_comp($comp, $dashId);
			}

			// supprimer les composants qui ne sont plus utilisés
			$componantsToDelete = $_SESSION["componants_to_delete"];
			foreach ($componantsToDelete as $index => $compid) {
				SessionManagement::get_curent_log_instance()->new_log("Suppréssion du lien du composant $compid : " . $index + count($dash->get_composants()) . "/" . count($dash->get_composants()) + count($componantsToDelete));
				$comp_repo->try_delete($comp_repo->get_composant_by_id($compid));
				$query = "DELETE from Composant_dashboard WHERE composant_id = :compId AND dashboard_id = :dashId";
				$values = [":compId" => $compid, ":dashId" => $dashId];
				DatabaseConnection::executeQuery($query, $values);
			}

			// supprimer les instances de CritereGeo_dashboard
			// juste construire une requette SQL
			SessionManagement::get_curent_log_instance()->new_log("Mise a jour complète");
		} catch (Exception $e) {
			MsgRepository::newError("Erreur lors de la mise à jour du dashboard", "Le dashboard n'a pas pu être mis à jour.\n" . $e->getMessage());
		} catch (PDOException $e) {
			MsgRepository::newError("Erreur lors de la mise à jour du dashboard", "Le dashboard n'a pas pu être mis à jour.\n" . $e->getMessage());
		}
	}

	public function save_new_dashboard(Dashboard $dash)
	{
		SessionManagement::get_curent_log_instance()->new_log("Enregistrement du dashboard dans la BDD...", LogInstance::IMPORTANT);
		try {
			$values = $dash->formatTableau();
			$values[":createur_id"] = SessionManagement::getUser()->getId();
			$values[":id"] = NULL;
			$dashId = (int) $this->create($dash, $values);

			// enregistrer les liens critereGeo
			SessionManagement::get_curent_log_instance()->new_log("Ajout des critères géographiques du dashboard");
			foreach ($dash->get_region() as $type => $ids) {
				$DB_type = DashboardRepository::REVERSE_TYPE_GEO[$type];
				foreach ($ids as $value) {
					$query = "INSERT INTO CritereGeo_dashboard (dashboard_id, type_critere, critere_id) VALUES (:dashboard_id, :type_critere, :critere_id)";
					$values = [":dashboard_id" => $dashId, ":type_critere" => $DB_type, ":critere_id" => $value];
					DatabaseConnection::executeQuery($query, $values);
				}
			}

			// parcourir les composants et les enregistrés
			foreach ($dash->get_composants() as $index => $comp) {
				SessionManagement::get_curent_log_instance()->new_log("Enregistrement du composant " . $index + 1 . "/" . count($dash->get_composants()));
				$compId = (new ComposantRepository)->save_new($comp, $dashId);
			}

			SessionManagement::get_curent_log_instance()->new_log("Dashboard enregistré", LogInstance::GREEN);
			return $dashId;
		} catch (Exception $e) {
			MsgRepository::newError("Erreur lors de la sauvegarde du dashboard", "Le dashboard n'a pas pu être sauvegardé.\n" . $e->getMessage());
			return null;
		} catch (PDOException $e) {
			MsgRepository::newError("Erreur lors de la sauvegarde du dashboard", "Le dashboard n'a pas pu être sauvegardé.\n" . $e->getMessage());
			return null;
		}
	}

	public function delete_dashboard(Dashboard $dash): Dashboard|null
	{
		try {
			// supprimer le dashboard
			$this->delete($dash->get_id());

			// supprimer les liens géo
			$query = "DELETE FROM CritereGeo_dashboard WHERE dashboard_id = :dashboard_id";
			DatabaseConnection::executeQuery($query, [":dashboard_id" => $dash->get_id()]);
			// supprimer les liens avec les composants
			$query = "DELETE FROM Composant_dashboard WHERE dashboard_id = :dashboard_id";
			DatabaseConnection::executeQuery($query, [":dashboard_id" => $dash->get_id()]);

			$compo = new ComposantRepository();
			foreach ($dash->get_composants() as $item) {
				$compo->try_delete($item);
			}
			$dash->setId(null);
			return $dash;
		} catch (PDOException $e) {
			MsgRepository::newError("Erreur lors de la suppression du dashboard", "Le dashboard n'a pas pu être supprimé.\n" . $e->getMessage());
			return null;
		} catch (Exception $e) {
			MsgRepository::newError("Erreur lors de la suppression du dashboard", "Le dashboard n'a pas pu être supprimé.\n" . $e->getMessage());
			return null;
		}
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

	public function buildPrivatisation(&$values, ?string $privatisation = null)
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

	public function filtre(?string $date_debut, ?string $date_fin, ?bool $privatisation): array
	{
		$conditions = [];
		$params = [];

		if (!empty($date_debut)) {
			$conditions[] = "date_debut >= :date_debut";
			$params['date_debut'] = $date_debut;
		}
		if (!empty($date_fin)) {
			$conditions[] = "date_fin <= :date_fin";
			$params['date_fin'] = $date_fin;
		}
		if ($privatisation !== null) { // Vérification explicite de null
			$conditions[] = "privatisation = :privatisation";
			$params['privatisation'] = (int) $privatisation; // Convertir booléen en entier (0 ou 1)
		}

		$query = "SELECT * FROM Dashboards";
		if (!empty($conditions)) {
			$query .= " WHERE " . implode(" AND ", $conditions);
		}
		return DatabaseConnection::fetchAll($query, $params);
	}
}
