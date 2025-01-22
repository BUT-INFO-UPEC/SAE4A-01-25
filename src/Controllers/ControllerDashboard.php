<?php

namespace Src\Controllers;

use Src\Model\DataObject\Dashboard;
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
		$dashboards = Dashboard::get_dashboards();

		$titrePage = "Liste Des Dashboards";
		$cheminVueBody = "browse.php";
		require('../src/Views/Template/views.php');
	}

	static function create(): void
	{
		$station = Requetteur_BDD::get_station();

		$titrePage = "Edition d'un Dashboard";
		$cheminVueBody = "create.php";
		require('../src/Views/Template/views.php');
	}
	#endregion entry

	// =======================
	//    GET METHODS
	// =======================
	#region get
	static public function visu_dashboard(): void
	{
		$dash = Dashboard::get_dashboard_by_id($_GET["dashId"]);

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
}
