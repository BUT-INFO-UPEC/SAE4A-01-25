<?php

namespace Src\Controllers;

use Exception;
use RuntimeException;
use Src\Model\Repository\DashboardRepository;
use Src\Config\MsgRepository;
use Src\Model\API\Requetteur_API;

class ControllerDashboard extends AbstractController
{
	static public function default(): void
	{
		ControllerDashboard::browse();
	}

	static function getActionsList(): array
	{
		return array('Liste' => 'action=browse', 'Creation' => 'action=create');
	}

	// =======================
	//    ENTRY METHODS
	// =======================
	#region entry
	static public function browse(): void
	{
		// Ajout des filtres et tri pour les tableaux de bord
		$region = $_GET['region'] ?? null;
		$order = $_GET['order'] ?? 'recent'; // Valeurs possibles : recent, most_viewed
		$dateFilter = $_GET['date'] ?? 'today';
		$customStartDate = $_GET['start_date'] ?? null;
		$customEndDate = $_GET['end_date'] ?? null;
		$privatisation = $_GET['privatisation'] ?? null;

		$constructeur = new DashboardRepository();
		$dashboards = $constructeur->get_dashboards($region, $order, $dateFilter, $customStartDate, $customEndDate, $privatisation);

		$titrePage = "Liste Des Dashboards";
		$cheminVueBody = "browse.php";
		require('../src/Views/Template/views.php');
	}

	static function new_dashboard(): void
	{
		$_GET['dashId'] =  0;

		// MsgRepository::newSuccess("Nouveau dashboard initialisé", "", MsgRepository::No_REDIRECT);

		ControllerDashboard::edit();
	}

	static function edit(): void
	{
		if (isset($_GET['dashId'])) {
			try {
				$dash = (new DashboardRepository())->get_dashboard_by_id($_GET['dashId']);
				$_SESSION['dash'] = $dash;
			} catch (RuntimeException $e) {
				MsgRepository::newError('Erreur lors de la récupération du dashboard', $e->getMessage());
			}
		} elseif (isset($_SESSION['dash'])) {
			$dash = $_SESSION['dash'];
		} else {
			MsgRepository::newWarning("Dashboard non défini", "Pour éditer un dashboard, merci d'utiliser les boutons prévus a cet effet ou de définir l'id du dashboard que vous souhaitez utiliser comme model.");
		}

		$titrePage = "Edition d'un Dashboard";
		$cheminVueBody = "edit.php";
		require('../src/Views/Template/views.php');
	}

	static function save(): void
	{
		if (!empty($_SESSION['dash'])) {
			$dash = $_SESSION['dash'];
			$constructeur = new DashboardRepository();
			if ($dash->get_createur() == $_SESSION['user_id']) {
				$constructeur->update_dashboard_by_id($dash);
			} else {
				$constructeur->save_new_dashboard($dash);
			}
		} else {
			MsgRepository::newWarning("Dashboard non défini", "Pour sauvegarder un dashboard, merci d'utiliser les boutons prévus a cet effet.");
		}

		// vérifier les droits 
		// GET['OLD_Id'] pour déterminer le dashboard a copier (0 pour un nouveau)
		// $station = Requetteur_BDD::get_station();
		// Enregistrer directement pour récupérer le nouvel ID (et déclencher l'enregistrement des logs)
	}
	#endregion entry

	// =======================
	//    GET METHODS
	// =======================
	#region get
	static public function visu_dashboard(): void
	{
		// vérifier les droits 
		$constructeur = new DashboardRepository();
		$dash = $constructeur->get_dashboard_by_id($_GET["dashId"]);

		$titrePage = "Visualisatoin du Dashboard";
		$cheminVueBody = "visu.php";
		require('../src/Views/Template/views.php');
	}
	#endregion get

	// =======================
	//    POST METHODS
	// =======================
	#region post
	#endregion post


	// Test Function
	public static function testDash()
	{
		$titrePage = "Test de récupération des données API";

		// Définition des paramètres de la requête
		// $select = ['tc', 'libgeo', 'date'];
		// $where = [];
		// $group_by = [];
		// $order_by = null;
		// $limit = 1999; // Nombre de résultats par lot
		// $offset = null; // Départ de la récupération
		// $refine = []; // Refinement des données
		// $exclude = []; // Exclusion des données
		// $time_zone = null; // Time zone

		try {
			// Appel de la méthode pour récupérer les données via l'API
			// $data = Requetteur_API::fetchData(
			// 	$select,
			// 	$where,
			// 	$group_by,
			// 	$order_by,
			// 	$limit,
			// 	$offset,
			// 	$refine,
			// 	$exclude,
			// 	$time_zone
			// );

			// // Vérification du retour de la méthode
			// if (empty($data)) {
			// 	throw new Exception("Aucune donnée n'a été retournée par l'API.");
			// }

			// Exploitation des données récupérées
			$cheminVueBody = "test_dash.php";
			require('../src/Views/Template/views.php');
		} catch (Exception $e) {
			$erreur = $e->getMessage();
			MsgRepository::newError($erreur);
		}
	}
}
