<?php

namespace Src\Controllers;

use Exception;
use Src\Config\MsgRepository;
use Src\Model\API\Requetteur_API;
use Src\Model\API\Constructeur_Requette_API;

class ControllerTests extends AbstractController
{

	static public function default(): void
	{
		header('Location: ?controller=ControllerGeneral');
	}

	static function getActionsList(): array
	{
		return [];
	}

	public static function testDash()
	{
		try {
			// Appel de la méthode pour récupérer les données via l'API

			$requete = new Constructeur_Requette_API(
				["t"]
			);

			$data = Requetteur_API::fetchData($requete);
		} catch (Exception $e) {
			MsgRepository::newError("Erreur lors de la requette a la banque de donées de Météofrance", $e->getMessage(), MsgRepository::NO_REDIRECT);
		}

		// Exploitation des données récupérées
		$titrePage = "Test de récupération des données API";
		$cheminVueBody = "test_dash.php";
		require('../src/Views/Template/views.php');
	}

	public static function carte_region()
	{
		$titrePage = "Carte Regions";
		$cheminVueBody = "carte_regions.php";
		require('../src/Views/Template/views.php');
	}

	public static function developpement_js()
	{
		$titrePage = "Modularisation js";
		$cheminVueBody = "onglets_js.php";
		require('../src/Views/Template/views.php');
	}
}
