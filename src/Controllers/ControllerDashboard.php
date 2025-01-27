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
			$valeurs = new AttributRepository();
			$association = new GrouppingRepository();
			$analysis = new AggregationRepository();

			$represtation = $represtation->get_representations();
			$valeurs = $valeurs->get_attributs();
			$association = $association->get_grouppings();
			$analysis = $analysis->get_aggregations();
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

		if (!empty($_SESSION['dash'])) {
			$dash = $_SESSION['dash'];
			$componantsToDelete = ControllerDashboard::update_dashboard_from_POST($dash);
			$_SESSION["dash"] = $dash;

			// vérifier si c'est une requette "visualiser modifications sans enregisterer"
			if (isset($_GET["upload"]) && $_GET["upload"] == "false") header("Location: ?controller=ControllerDashboard&action=visu_dashboard");

			// vérifier si l'utilisateur est connécté
			if (UserManagement::getUser() == null) {
				MsgRepository::newWarning('Non connécté', 'Vous devez etre enregistré(e) pour pouvoir enregistrer un dashboard');
			}

			$constructeur = new DashboardRepository();
			if ($dash->get_createur() == UserManagement::getUser()->getId() or $_POST["duplicate"] == true) {
				$constructeur->update_dashboard_by_id($dash, $componantsToDelete);
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

		$_SESSION['dash'] = $dash;

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

	private static function update_dashboard_from_POST(Dashboard &$dash): array
	{
		// récupérer les POST
		$dash->setStartDate($_POST['start_date']);
		$dash->setStartDateRelative(isset($_POST['dynamic_start']) && $_POST['dynamic_start'] == 'on');
		$dash->setEndDate($_POST['end_date']);
		$dash->setEndDateRelative(isset($_POST['dynamic_end']) && $_POST['dynamic_end'] == 'on');

		// récupérer toutes les staitons, régions, ect... chéckés
		$criteres_geo = [];
		if (!empty($_POST['regions']))
			$cryteres_geo['reg_id'] = $_POST['regions'];
		if (!empty($_POST['regions']))
			$cryteres_geo['epci_id'] = $_POST['depts'];
		if (!empty($_POST['regions']))
			$cryteres_geo['ville_id'] = $_POST['villes'];
		if (!empty($_POST['regions']))
			$cryteres_geo['numer_sta'] = $_POST['stations'];

		$compNb = $_POST["count_id"];
		$dash->delComposants($compNb);
		$componantsToDelete = [];
		foreach ($dash->get_composants() as $value) {
			// tt les setters
		}
		for ($i=count($dash->get_composants()); $i < $compNb; $i++) { 
			// initialiser les autrs composants
		}

		// retourner les composants qui sont de trop aprés les avoir unset
		return $componantsToDelete;
	}
}
