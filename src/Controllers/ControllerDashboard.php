<?php

namespace Src\Controllers;

use Exception;
use Src\Model\DataObject\Composant;
use Src\Model\DataObject\Dashboard;
use Src\Model\DataObject\Requette_API;
use Src\Model\Repository\DashboardRepository;
use Src\Model\Repository\MsgRepository;
use Src\Model\Repository\Requetteur_API;
use Src\Model\Repository\Requetteur_BDD;

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
		$constructeur = new DashboardRepository();
		$dashboards = $constructeur->get_dashboards();

		// Ajout des filtres et tri pour les tableaux de bord
		$region = $_GET['region'] ?? null;
		$order = $_GET['order'] ?? 'recent'; // Valeurs possibles : recent, most_viewed
		$dateFilter = $_GET['date'] ?? 'today';
		$customStartDate = $_GET['start_date'] ?? null;
		$customEndDate = $_GET['end_date'] ?? null;

		// Filtrage des tableaux de bord
		$filteredDashboards = array_filter($dashboards, function ($dash) use ($region, $dateFilter, $customStartDate, $customEndDate) {
			$passesRegionFilter = $region ? $dash->get_region() === $region : true;
			$passesDateFilter = true;

			if ($dateFilter === 'yesterday') {
				$passesDateFilter = strtotime($dash->get_date()) >= strtotime('yesterday') && strtotime($dash->get_date()) < strtotime('today');
			} elseif ($dateFilter === 'today') {
				$passesDateFilter = strtotime($dash->get_date()) >= strtotime('today') && strtotime($dash->get_date()) < strtotime('tomorrow');
			} elseif ($dateFilter === 'this_week') {
				$passesDateFilter = strtotime($dash->get_date()) >= strtotime('monday this week') && strtotime($dash->get_date()) < strtotime('monday next week');
			} elseif ($dateFilter === 'custom' && $customStartDate && $customEndDate) {
				$passesDateFilter = strtotime($dash->get_date()) >= strtotime($customStartDate) && strtotime($dash->get_date()) <= strtotime($customEndDate);
			}

			return $passesRegionFilter && $passesDateFilter;
		});

		// Tri des tableaux de bord
		usort($filteredDashboards, function ($a, $b) use ($order) {
			if ($order === 'most_viewed') {
				return $b->get_views() - $a->get_views();
			} else { // Par défaut : 'recent'
				return strtotime($b->get_date()) - strtotime($a->get_date());
			}
		});

		$titrePage = "Liste Des Dashboards";
		$cheminVueBody = "browse.php";
		require('../src/Views/Template/views.php');
	}

	static function new_dashboard(): void
	{
		$_GET['dash_id'] = 0;

		ControllerDashboard::edit();
	}

	static function edit(): void
	{
		// vérifier les droits 
		// charger le dashboard GET['ID]

		$titrePage = "Edition d'un Dashboard";
		$cheminVueBody = "create.php";
		require('../src/Views/Template/views.php');
	}

	static function save(): void
	{

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


	public static function testDash()
	{
		$titrePage = "Test de récupération des données API";
		$select = ["t as temperatures", "tc as temperature_en_Celcius", 'date as date_de_mesure', 'libgeo as ville'];
		$where = [
		];
		$group_by = [];
		$order_by = [
			'libgeo',
			'date',
		];
		$limit = 100;
		$offset = null;
		$refine_name = null;
		$refine_value = null;
		$exclude_name = null;
		$exclude_value = null;
		$time_zone = null;
		try {
			$data = Requetteur_API::fetchAll(
				$select,
				$where,
				$group_by,
				$order_by,
				$limit,
				$offset,
				$refine_name,
				$refine_value,
				$exclude_name,
				$exclude_value,
				$time_zone
			);

			$cheminVueBody = "test_dash.php";
			require('../src/Views/Template/views.php');
		} catch (Exception $e) {
			$erreur = $e->getMessage();
			MsgRepository::newError($erreur);
		}
	}
}
