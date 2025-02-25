<?php

namespace Src\Controllers;

use Exception;
use PDOException;
use RuntimeException;
use Src\Model\Repository\AggregationRepository;
use Src\Model\Repository\AttributRepository;
use Src\Model\Repository\DashboardRepository;
use Src\Config\MsgRepository;
use Src\Config\UserManagement;
use Src\Model\DataObject\Dashboard;
use Src\Model\Repository\ComposantRepository;
use Src\Model\Repository\GrouppingRepository;
use Src\Model\Repository\RepresentationRepository;

class ControllerDashboard extends AbstractController
{
	static public function default(): void
	{
		ControllerDashboard::browse();
	}

	#region entry
	// =======================
	//    ENTRY METHODS
	// =======================

	/** Retourne la page d'édition de dashboards avec initialisation sur le dashboard par défaut
	 * 
	 * @return void
	 */
	static function new_dashboard(): void
	{
		// Initialisation sur le dashboard par défaut (id = 0)
		$_GET['dashId'] =  0;

		// MsgRepository::newSuccess("Nouveau dashboard initialisé", "", MsgRepository::NO_REDIRECT);

		// Appel de la page édit une fois le dashboard de base défini
		ControllerDashboard::edit();
	}
	#endregion entry

	#region get
	// =======================
	//    GET METHODS
	// =======================

	/** Requette de la liste des dashboard selon des paramètres optionnels en GET
	 * 
	 * Retourne la page de liste avec la liste des dashboards selon les filtres apliqués
	 * La liste des filtres disponible est disponible sur la page liste sous la forme d'un formulaire
	 * 
	 * @return void
	 */
	static public function browse(): void
	{
		// Ajout des filtres et tri pour les tableaux de bord
		$defaultGeo = ControllerDashboard::GET_POST_criteres_geo($_GET);
		$order = $_GET['order'] ?? 'recent'; // Valeurs possibles : recent, most_viewed
		$dateFilter = $_GET['date'] ?? 'today';
		$customStartDate = $_GET['start_date'] ?? null;
		$customEndDate = $_GET['end_date'] ?? null;
		$privatisation = $_GET['privatisation'] ?? null;

		// requette de la liste des dashboards correspondants aux filtres précisés
		$constructeur = new DashboardRepository();
		$dashboards = $constructeur->get_dashboards($defaultGeo, $order, $dateFilter, $customStartDate, $customEndDate, $privatisation);

		// Appel page
		$titrePage = "Liste Des Dashboards";
		$cheminVueBody = "browse.php";
		require('../src/Views/Template/views.php');
	}

	/** Retourne la page de visualisatoin du dashboard précisé
	 * 
	 * La page de visualisation permet de voir les informations du dashboard ainsi que ses graphiques analytiques
	 * 
	 * @return void
	 */
	static public function visu_dashboard(): void
	{
		if (isset($_GET['dashId'])) {
			$constructeur = new DashboardRepository();
			$dash = $constructeur->get_dashboard_by_id($_GET["dashId"]);
			$dash->buildData();

			$_SESSION['dash'] = $dash;
		} elseif (isset($_SESSION['dash'])) {
			$dash = $_SESSION['dash'];
		}

		// Appel page
		$titrePage = "Visualisatoin du Dashboard";
		$cheminVueBody = "visu.php";
		require('../src/Views/Template/views.php');
	}

	/** Retourne une page d'édition où les données du dashboard en cours ou celui de l'id précisé
	 * 
	 * La page charge les données du dashboard et offre des options de visualisation ou sauvegarde en fonction des droits de l'utilisateur sur le dit dashboard
	 * 
	 * @return void
	 */
	static function edit(): void
	{
		try {
			// récupérer la liste des paramètres des composants pour la vue
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

		// Initialisation du dashboard a éditer
		if (isset($_GET['dashId'])) {
			// Prioriser un id spécifié, tester la récupération du dashbord
			try {
				$dash = (new DashboardRepository())->get_dashboard_by_id($_GET['dashId']);
				$_SESSION['dash'] = $dash;
			} catch (RuntimeException $e) {
				MsgRepository::newError('Erreur lors de la récupération du dashboard', $e->getMessage());
			}
		} elseif (isset($_SESSION['dash'])) {
			// Sinon, utiliser le dashboard stocké dans la session
			$dash = $_SESSION['dash'];
		} else {
			MsgRepository::newWarning("Dashboard non défini", "Pour éditer un dashboard, merci d'utiliser les boutons prévus a cet effet ou de définir l'id du dashboard que vous souhaitez utiliser comme model.");
		}

		// Initialisation des elements du dashboard pour la vue
		$dash_name = $dash->get_name();
		$dash_private = $dash->get_privatisation();
		$dash_date_debut = $dash->get_date();
		$dash_date_debut_r = $dash->dateDebutRelatif;
		$dash_date_fin = $dash->get_date("fin");
		$dash_date_fin_r = $dash->dateFinRelatif;
		$defaultGeo = $dash->get_region();

		// Initialisation des composants du dashboard pour la vue
		$composants = $dash->get_composants();
		$composant_attr = [];
		$composant_agr = [];
		$composant_grou = [];
		$composant_rep = [];
		foreach ($composants as $composant) {
			$composant_attr[] = $composant->get_attribut()->get_id();
			$composant_agr[] = $composant->get_aggregation()->get_id();
			$composant_grou[] = $composant->get_grouping()->get_id();
			$composant_rep[] = $composant->get_representation()->get_id();
		}

		// Appel page
		$titrePage = "Edition d'un Dashboard";
		$cheminVueBody = "edit.php";
		require('../src/Views/Template/views.php');
	}
	#endregion get

	#region post
	// =======================
	//    POST METHODS
	// =======================

	/** Fonction interne de la mise a jour d'un dashboard avec option de duplication ou écrasement
	 * 
	 * Mets a jour le dashbord dans la session a partir des paramètres POST
	 * Peut ajouter un nouveau dashboard dans la BDD partir du dashboard mis a jour
	 * Peur écraser le dashboard original dans la BDD avec les données du nouveau pour sauvegarde
	 * 
	 * Redirige ensuite vers la visualisatoin du dashboard mis a jour
	 * 
	 * @return void
	 */
	static function save(): void
	{
		try {
			if (!empty($_SESSION['dash'])) {
				// Mettre a jour le dashboard dans la session (données dynamiques)
				$dash = $_SESSION['dash'];
				$componantsToDelete = ControllerDashboard::update_dashboard_from_POST($dash);
				$_SESSION["dash"] = $dash;

				// vérifier si c'est une requette "visualiser modifications sans enregisterer"
				if (isset($_GET["upload"]) && $_GET["upload"] == "false") {
					header("Location: ?controller=ControllerDashboard&action=visu_dashboard");
					exit;
				}

				// vérifier si l'utilisateur est connécté
				if (UserManagement::getUser() == null) MsgRepository::newWarning('Non connécté', 'Vous devez etre enregistré(e) pour pouvoir sauvegarder un dashboard');

				$constructeur = new DashboardRepository();
				if ($dash->get_createur() != UserManagement::getUser()->getId() or isset($_POST["duplicate"])) {
					// Créer un nouveau dashboard a partir des données de la requette
					$constructeur->save_new_dashboard($dash);
					MsgRepository::newSuccess("Dashboard crée avec succés", "Votre dashboard a bien été enregistré, vous pouvez le retrouver dans 'Mes dashboards'", "Location: ?controller=ControllerDashboard&actoin=visu_dashboard");
				} else {
					// Ecraser l'ancien dashboard pour le mettre a jour avec les données de la requette
					$constructeur->update_dashboard_by_id($dash, $componantsToDelete);
					$dashId = $dash->get_id();
					MsgRepository::newSuccess("Dashboard mis à jour", "Votre dashboard a bien été enregistré, vous pouvez le retrouver dans 'Mes dashboards'", "Location: ?controller=ControllerDashboard&action=visu_dashboard&dash&dashId=$dashId");
				}
			} else {
				MsgRepository::newWarning("Dashboard non défini", "Pour sauvegarder un dashboard, merci d'utiliser les boutons prévus a cet effet.");
			}
		} catch (PDOException $e) {
			MsgRepository::newError('Erreur lors de la sauvegarde du dashboard');
		} catch (Exception $e) {
			MsgRepository::newError('Erreur lors de la sauvegarde du dashboard');
		}
	}
	#endregion post

	#region utility
	// =======================
	//    UTILITY METHODS
	// =======================

	/** Mets en forme la liste des stations, villes départements et régions
	 * 
	 * Mets en forme la liste des critères géographiques séléctionnés pour utilisation dans liste elements
	 * 
	 * @param mixed $tab
	 * 
	 * @return array Liste encapsulatn toutes les donénes géographiques
	 */
	private static function GET_POST_criteres_geo(&$tab): array
	{ // récupérer toutes les staitons, régions, ect... chéckés
		$cryteres_geo = [];
		if (!empty($tab['regions']))
			$criteres_geo['reg_id'] = $tab['regions'];

		if (!empty($tab['depts']))
			$criteres_geo['epci_id'] = $tab['depts'];

		if (!empty($tab['villes']))
			$criteres_geo['ville_id'] = $tab['villes'];

		if (!empty($tab['stations']))
			$criteres_geo['numer_sta'] = $tab['stations'];
		return $cryteres_geo;
	}
	/** Performe une mise ajour des données dynamiques (instance) d'un dashboard deppuis une requette POST
	 * 
	 * @param Dashboard $dash Le dashboard a mettre a jour
	 * 
	 * @return array Le résultat du delComposants.
	 * @see Dashboard::delComposants(int $nbComps)
	 */
	private static function update_dashboard_from_POST(Dashboard &$dash): array
	{
		// récupérer les POST simples
		$dash->setStartDate($_POST['start_date']);
		$dash->setStartDateRelative(isset($_POST['dynamic_start']) && $_POST['dynamic_start'] == 'on');
		$dash->setEndDate($_POST['end_date']);
		$dash->setEndDateRelative(isset($_POST['dynamic_end']) && $_POST['dynamic_end'] == 'on');

		// récupère les données géo
		$cryteres_geo = ControllerDashboard::GET_POST_criteres_geo($_POST);
		// MsgRepository::newWarning("Verif POST citeres geo", var_export($cryteres_geo, true), MsgRepository::NO_REDIRECT);
		$dash->setCriteresGeo($cryteres_geo);
		// MsgRepository::newWarning("Verif update citeres geo", var_export($dash, true), MsgRepository::NO_REDIRECT);

		// mise a jour des composants
		$compNb = $_POST["count_id"];
		$componantsToDelete = $dash->delComposants((int) $compNb);

		foreach ($dash->get_composants() as $index => $comp) {
			// Mettre a jour les composants
			$index = $index + 1;
			$params['titre'] = $_POST["titre_composant_$index"];
			$params['chartId'] = $index;
			$comp->set_params($params);
			$comp->set_aggregation($_POST["analysis_$index"]);
			$comp->set_attribut($_POST["value_type_$index"]);
			$comp->set_grouping($_POST["association_$index"]);
			$comp->set_visu($_POST["visu_type_$index"]);
		}
		for ($i = count($dash->get_composants()); $i < $compNb; $i++) {
			// Ajouter les composants suplémentaires
			$objetFormatTableau = [];
			$objetFormatTableau['id'] = null;
			$objetFormatTableau['attribut'] = "";
			$objetFormatTableau['aggregation'] = '';
			$objetFormatTableau['groupping'] = "";
			$objetFormatTableau['repr_type'] = '';

			$params['titre'] = $_POST["titre_composant_$i"];
			$params['chartId'] = $i;
			$objetFormatTableau['params_affich'] = $params;
			$dash->addComposant((new ComposantRepository)->arrayConstructor($objetFormatTableau));
		}

		// retourner les composants qui sont de trop aprés les avoir unset
		return $componantsToDelete;
	}
	#endregion utility
}
