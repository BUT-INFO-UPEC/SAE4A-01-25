<?php

namespace Src\Controllers;

use Exception;
use RuntimeException;
use Src\Model\Repository\AggregationRepository;
use Src\Model\Repository\AttributRepository;
use Src\Model\Repository\DashboardRepository;
use Src\Config\MsgRepository;
use Src\Config\UserManagement;
use Src\Model\DataObject\Dashboard;
use Src\Model\Repository\DatabaseConnection;
use Src\Model\Repository\GrouppingRepository;
use Src\Model\Repository\RepresentationRepository;

class ControllerDashboard extends AbstractController
{
	static public function default(): void
	{
		ControllerDashboard::browse();
	}

	static function getActionsList(): array
	{
		return ['Liste' => 'action=browse', 'Creation' => 'action=create'];
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

		// MsgRepository::newSuccess("Nouveau dashboard initialisé", "", MsgRepository::NO_REDIRECT);

		ControllerDashboard::edit();
	}

	static function edit(): void
	{
		$tables = [
			'regions',
			'depts',
			'villes',
			'stations'
		];
		try {
			// Récupération des données depuis les tables
			$regions = DatabaseConnection::getTable('regions');
			$depts = DatabaseConnection::getTable('depts');
			$villes = DatabaseConnection::getTable('villes');
			$stations = DatabaseConnection::getTable('stations');

			$represtation = new RepresentationRepository();
			$attr = new AttributRepository();
			$grp = new GrouppingRepository();
			$aggr = new AggregationRepository();

			$visu = $represtation->get_representations();
			$attributs = $attr->get_attributs();
			$grouping = $grp->get_grouppings();
			$aggregations = $aggr->get_aggregations();
		} catch (Exception $e) {
			// Gestion des erreurs si une table est introuvable ou si une autre exception se produit
			die("Erreur lors de la récupération des données : " . $e->getMessage());
		}
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
		if (UserManagement::getUser() == null) {
			MsgRepository::newError('Non connécté', 'Vous devez etre enregistré(e) pour pouvoir enregistrer un dashboard');
		}
		if (!empty($_SESSION['dash'])) {
			$dash = $_SESSION['dash'];
			ControllerDashboard::update_dashboard_from_POST($dash);
			$constructeur = new DashboardRepository();
			if ($dash->get_createur() == UserManagement::getUser()->getId() or $_POST["duplicate"] == true) {
				$constructeur->update_dashboard_by_id($dash);
				$_GET["dashId"] = $dash->get_id();
				MsgRepository::newSuccess("Dashboard mis à jour", "Votre dashboard a bien été enregistré, vous pouvez le retrouver dans 'Mes dashboards'", MsgRepository::NO_REDIRECT);
			} else {
				$constructeur->save_new_dashboard($dash);
				MsgRepository::newSuccess("Dashboard crée avec succés", "Votre dashboard a bien été enregistré, vous pouvez le retrouver dans 'Mes dashboards'", "?controller=ControllerDashboard&actoin=visu_dashboard");
			}
		} else {
			MsgRepository::newWarning("Dashboard non défini", "Pour sauvegarder un dashboard, merci d'utiliser les boutons prévus a cet effet.");
		}
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
		$dash->buildData();

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

	private static function update_dashboard_from_POST(Dashboard &$dash): void
	{
		// récupérer les POST
		$dash->setStartDate($_POST['start_date']);
		$dash->setStartDateRelative($_POST['dynamic_start']);
		$dash->setEndDate($_POST['end_date']);
		$dash->setEndDateRelative($_POST['dynamic_end']);

		// récupérer toutes les staitons, régions, ect... chéckés
		foreach ($_POST['samplecheck'] as &$value) {
		}

		$compNb = $_POST[""];
		$i = 0;
		foreach ($dash->get_composants() as $value) {
		}
	}
}
