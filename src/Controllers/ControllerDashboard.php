<?php

namespace Src\Controllers;

use Exception;
use PDOException;
use RuntimeException;
use Src\Config\Utils\LogInstance;
use Src\Model\DataObject\Composant;
use Src\Model\Repository\AggregationRepository;
use Src\Model\Repository\AnalysisRepository;
use Src\Model\Repository\AttributRepository;
use Src\Model\Repository\DashboardRepository;
use Src\Config\Utils\MsgRepository;
use Src\Config\Utils\SessionManagement;
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
		// Initialisation sur le dashboard par défaut (id = 2)
		$_GET['dashId'] =  2;

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

			SessionManagement::setDash($dash);
		} elseif (isset($_SESSION['dash'])) {
			$dash = $_SESSION['dash'];
		}
		$dash->buildData();

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

		$dashid = $_GET['dashId'] ?? null;

		// Initialisation du dashboard a éditer
		if (isset($dashid)) {
			// Prioriser un id spécifié, tester la récupération du dashbord
			try {
				$dash = (new DashboardRepository())->get_dashboard_by_id($dashid);
				SessionManagement::setDash($dash);
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
		$composants = $dash->get_composants();

		// MsgRepository::newWarning("géo", var_export($defaultGeo, true), MsgRepository::NO_REDIRECT);

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
	 * Peut écraser le dashboard original dans la BDD avec les données du nouveau pour sauvegarde
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
				if (!empty($_POST)) ControllerDashboard::update_dashboard_from_POST($dash); // ne mettre a jour le dashboard que si demander, concretement, important pour la récupération lors d'une délétion regrétée
				$_SESSION["dash"] = $dash;

				// vérifier si c'est une requette "visualiser modifications sans enregisterer"
				if (isset($_GET["upload"]) && $_GET["upload"] == "false") {
					header("Location: ?controller=ControllerDashboard&action=visu_dashboard");
					exit;
				}

				// vérifier si l'utilisateur est connécté
				if (SessionManagement::getUser() == null) MsgRepository::newWarning('Non connécté', 'Vous devez etre enregistré(e) pour pouvoir sauvegarder un dashboard');

				$constructeur = new DashboardRepository();
				if ($dash->get_createur() == SessionManagement::getUser()->getId() and !isset($_GET["duplicate"])) {
					// Ecraser l'ancien dashboard pour le mettre a jour avec les données de la requette
					$constructeur->update_dashboard($dash);
					$dashId = $dash->get_id();
					MsgRepository::newSuccess("Dashboard mis à jour", "Votre dashboard a bien été enregistré", "?controller=ControllerDashboard&action=visu_dashboard&dashId=$dashId");
				} else {
					// Créer un nouveau dashboard a partir des données de la requette
					$dashId = $constructeur->save_new_dashboard($dash);
					MsgRepository::newSuccess("Dashboard crée avec succés", "Votre dashboard a bien été enregistré, vous pouvez le retrouver dans 'Mes dashboards'", "?controller=ControllerDashboard&action=visu_dashboard&dashId=$dashId");
				}
			} else {
				MsgRepository::newWarning("Dashboard non défini", "Pour sauvegarder un dashboard, merci d'utiliser les boutons prévus a cet effet.");
			}
		} catch (Exception $e) {
			MsgRepository::newError('Erreur lors de la sauvegarde du dashboard', $e->getMessage());
		}
	}

	static function delete(): void
	{
		$constructeur = new DashboardRepository();
		if (isset($_SESSION['dash'])) {
			$dash = $_SESSION['dash'];
		}
		if (isset($_GET["dash_id"])) {
			$dash = $constructeur->get_dashboard_by_id($_GET["dash_id"]);
			SessionManagement::setDash($dash);
		}
		if (isset($dash)) {
			if ($dash->get_createur() == SessionManagement::getUser()->getId()) {
				$_SESSION['dash'] = $constructeur->delete_dashboard($dash);
				MsgRepository::newPrimary('Dashboard supprimmé', "<a href='?controller=ControllerDashboard&action=save&duplicate=true'> dernierre chance de le récupérer ! </a>"); // le dashboard est toujours enregistré dans la session, si l'utilisateur clique sur le lien, il sera a nouveau enregistré (sous un nouvel id)
			} else {
				MsgRepository::newError("Hacker !!!", "C'est pas bien d'essayer de supprimer les dashboards des autres !!!");
			}
		} else {
			MsgRepository::newError("Aucun dashboard séléctionné", "vous devez séléctionner un dashboard pour le supprimer", MsgRepository::LAST_PAGE);
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
	private static function GET_POST_criteres_geo($tab): array
	{ // récupérer toutes les staitons, régions, ect... chéckés
		$criteres_geo = [];
		if (!empty($tab['regions']))
			$criteres_geo['code_reg'] = array_map('intval', $tab['regions']);

		if (!empty($tab['depts']))
			$criteres_geo['code_dep'] = array_map('intval', $tab['depts']);

		if (!empty($tab['villes']))
			$criteres_geo['codegeo'] = array_map('intval', $tab['villes']);

		if (!empty($tab['stations']))
			$criteres_geo['numer_sta'] = array_map('intval', $tab['stations']);
		return $criteres_geo;
	}

	/** Performe une mise ajour des données dynamiques (instance) d'un dashboard deppuis une requette POST
	 *
	 * @param Dashboard $dash Le dashboard a mettre a jour
	 *
	 * @return array Le résultat du delComposants.
	 * @see Dashboard::delComposants(int $nbComps)
	 */
	private static function update_dashboard_from_POST(Dashboard &$dash): void
	{
		SessionManagement::get_curent_log_instance()->new_log("Mise a jours dynamique du dashboard...");
		// récupérer les POST simples
		$dash->setTitle($_POST['nom_meteotheque']);
		$dash->setComments($_POST['comments']);
		$dash->setVisibility($_POST['visibility']);
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
		$compNb = $_POST["comp_count"];
		$dash->delComposants((int) $compNb);
		$nb_comps_initiaux = count($dash->get_composants());

		foreach ($dash->get_composants() as $index => $comp) {
			SessionManagement::get_curent_log_instance()->new_log("Mise a jours du composant " . $index + 1 . " / " . $nb_comps_initiaux);

			// Mettre a jour les composants
			$params['titre'] = $_POST["titre_composant_$index"];
			$params['chartId'] = $index;
			$comp->set_params($params);
			$comp->set_aggregation($_POST["analysis_$index"]);
			$comp->set_attribut($_POST["value_type_$index"]);
			$comp->set_grouping($_POST["association_$index"]);
			$comp->set_visu($_POST["visu_type_$index"]);
		}

		// Ajouter les composants suplémentaires
		for ($i = \count($dash->get_composants()); $i < $compNb; $i++) {
			SessionManagement::get_curent_log_instance()->new_log("Instanciation du composant $i/$compNb");
			$tab_analyse['id'] = null;
			$tab_analyse['attribut'] = (int) $_POST["value_type_$i"];
			$tab_analyse['aggregation'] = (int) $_POST["analysis_$i"];
			$tab_analyse['groupping'] = (int) $_POST["association_$i"];
			$tab_analyse['repr_type'] = (int) $_POST["visu_type_$i"];
			$ana = (new AnalysisRepository)->arrayConstructor($tab_analyse);

			if ($_SESSION["componants_to_delete"]) { // récupérer l'id d'un composant précédement supprimé si il existe pour éviter une suppression + création lors d'une mise a jour péraine et juste faire la dite mise a jour
				$id = array_pop($_SESSION["componants_to_delete"]);
				SessionManagement::get_curent_log_instance()->new_log("Récupération de l'id de composant " . $id . "précédement supprimé.");
			} else $id = null;
			$params['titre'] = $_POST["titre_composant_$i"];
			$params['chartId'] = $i;
			$new_comp = new Composant($ana, $params, $id);
			$dash->addComposant($new_comp);
		}
		SessionManagement::get_curent_log_instance()->new_log("Dashboard dynamique a jours...");
	}
	#endregion utility

	#region filtre
	// =======================
	//    FILTRE METHODS
	// =======================

	/** Retourne la page de filtre pour les dashboards
	 *
	 * La méthode filtre permet de séléctionner les critères de recherche pour les dashboards
	 *
	 */

	static function filtre(): void
	{
		try {
			$constructeur = new DashboardRepository();

			// Récupération sécurisée des paramètres GET avec valeur par défaut
			$date_debut = $_GET['date_debut'] ?? "";
			$date_fin = $_GET['date_fin'] ?? "";
			$privatisation = isset($_GET['privatisation']) ? (bool) $_GET['privatisation'] : null;

			// Récupérer les dashboards selon les critères de recherche
			$dashboards = $constructeur->filtre($date_debut, $date_fin, $privatisation);

			// Optionnel : Faire quelque chose avec $dashboards (affichage, retour, stockage en session, etc.)

		} catch (PDOException $e) {
			SessionManagement::get_curent_log_instance()->new_log(
				"Erreur PDO lors de la récupération des dashboards : " . $e->getMessage()
			);
		} catch (Exception $e) {
			SessionManagement::get_curent_log_instance()->new_log(
				"Erreur lors de la récupération des dashboards : " . $e->getMessage()
			);
		}
	}
	#endregion filtre
}
