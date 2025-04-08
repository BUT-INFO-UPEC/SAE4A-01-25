<?php

namespace Src\Controllers;

use Exception;
use PDOException;
<<<<<<< HEAD
use Src\Config\Utils\MsgRepository;
use Src\Model\DataObject\Utilisateur;
use Src\Model\Repository\UtilisateurRepository;
use Src\Config\Utils\SessionManagement;
=======
use Src\Config\MsgRepository;
use Src\Model\API\Constructeur_Requette_API;
use Src\Model\DataObject\Utilisateur;
use Src\Model\Repository\UtilisateurRepository;
use Src\Config\SessionManagement;
use Src\Model\API\Requetteur_API;
use Src\Model\Repository\DatabaseConnection;
>>>>>>> Visualisation-v2

class ControllerGeneral extends AbstractController
{
	static public function default(): void
	{
		ControllerGeneral::home();
	}

	#region entry
	// =======================
	//    ENTRY METHODS
	// =======================

	/** Retourne une page d'accueil statique
	 *
	 * @return void
	 */
	static public function home(): void
	{
		// Appel page
		$titrePage = "Salutations";
		$cheminVueBody = "home.php";
		require('../src/Views/Template/views.php');
	}
	#endregion entry

	#region get
	// =======================
	//    GET METHODS
	// =======================

	#endregion get

	#region user
	// =======================
	//    USER METHODS
	// =======================

	/** Permet à l'utilisateur de se connecter
	 *
	 * Récupère les informations POST pour vérifier la correspondance a un utilisateur existant
	 *
	 * Redirige vers la dernière page visutée
	 *
	 * @return void
	 */
	public static function connexion(): void
	{
		try {
			// Vérification des données envoyées par le formulaire
			$email = trim($_POST['email'] ?? '');
			$mdp = trim($_POST['password'] ?? '');
			// Vérification que les champs sont remplis
			if (empty($email) || empty($mdp)) {
				MsgRepository::newError('Formulaire incomplet.', '"Veuillez remplir tous les champs."');
			}

			// Récupération des informations utilisateur
			$user = (new UtilisateurRepository)->getUserByMailMdp($email, $mdp);

			if ($user !== null) {
			$_SESSION['user'] = $user;

			UtilisateurRepository::updateNbConn();

			MsgRepository::newSuccess("Connexion réussie.", "", MsgRepository::LAST_PAGE);
				
			} else {
				MsgRepository::newError("Utilisateur introuvable.", "Identifiants incorrects.");
			}
		} catch (PDOException $e) {
			MsgRepository::newError("Erreur lors de la connexion à la base de données.", $e->getMessage());
		} catch (Exception $e) {
			MsgRepository::newError("Erreur inconnue.", $e->getMessage());
		}
	}

	/** Permet l'inscription d'un nouvel utilisateur dans la DBB
	 *
	 *  Redirige vers la page profil
	 *
	 * @return void
	 */
	public static function inscription(): void
	{
		try {
			// Vérification des données envoyées par le formulaire
			$nom = $_POST['nom'] ?? null;
			$prenom = $_POST['prenom'] ?? null;
			$pseudo = $_POST['pseudo'] ?? null;
			$email = $_POST['mail'] ?? null;
			$mdp = $_POST['mdp'] ?? null;
			$confirme_mdp = $_POST['passwordConfirm'] ?? null;

			// Vérification que les champs sont remplis
			if (empty($nom) || empty($prenom) || empty($pseudo) || empty($email) || empty($mdp) || empty($confirme_mdp)) {
				MsgRepository::newError('Formulaire incomplet.', "Veuillez remplir tous les champs.");
			}
			// Vérification que les mots de passe sont identiques
			elseif ($mdp !== $confirme_mdp) {
				MsgRepository::newError('Erreur formulaire.', "Les mots de passe ne correspondent pas.");
			}
			$constructeur = new UtilisateurRepository;
			// Vérification de l'existence de l'utilisateur
			$user = $constructeur->getUserByMailMdp($email, $mdp);

			if ($user == null) {
				$user = new Utilisateur(
					$pseudo,
					$email,
					$nom,
					$prenom
				);

				// Enregistrement de l'utilisateur dans la base de données
				$id = $constructeur->insertUser($user, $mdp);

				// Récupération de l'utilisateur dans la session
				$user = $constructeur->getUserById($id);
				$_SESSION['user'] = $user;

				UtilisateurRepository::updateNbConn();

				// msg succes
				MsgRepository::newSuccess("Inscription réussie !", "Vous etes maintenant connécté(e)", "Location: ?controller=ControllerGeneral&action=profile");
			} else {
				MsgRepository::newWarning("L'utilisateur existe déjà.", "Un autre utilisateur semble avoir les mêmes informations que vous. <br/> Les doubles comptes ne sont pas autorisés !");
			}
		} catch (PDOException $e) {
			MsgRepository::newError("Erreur lors de la connexion à la base de données.", $e->getMessage(), MsgRepository::NO_REDIRECT);
		} catch (Exception $e) {
			MsgRepository::newError("Erreur lors de l'inscription.", $e->getMessage(), MsgRepository::NO_REDIRECT);
		}
	}

	/** Supprime l'utilisateur de la session
	 *
	 * Redirige vers la dernière page visitée
	 *
	 * @return void
	 */
	public static function deconnexion(): void
	{
		// Suppression de la session utilisateur
		$logs = $_SESSION['MSGs']["undying"];
		session_unset(); // supprimer toutes les infos de session
		session_start();
		$_SESSION['MSGs']["undying"] = $logs; // récupérer les logs
		MsgRepository::newSuccess("Déconnexion réussie !", "Vous etes maintenant déconnécté(e)");
	}

	/** Retourne la page d'information sur l'utilisateur connécté
	 *
	 * @return void
	 */
	public static function profile(): void
	{
		if (SessionManagement::getUser() == null)
			// Erreur + rediréction si l'utilisateur n'est pas connécté
			MsgRepository::newWarning('Non connécté', 'Vous devez etre enregistré(e) pour pouvoir enregistrer un dashboard', "?action=home");

		// Appel page
		$titrePage = "Profile";
		$cheminVueBody = "profil.php";
		$user = $_SESSION['user'];
		require('../src/Views/Template/views.php');
	}
	#endregion user

	/**
	 * Affiche la liste des stations disponible dans l'api
	 *
	 * @return void
	 */
	public static function stations(): void
	{
		// Appel page
		$titrePage = "Stations";
		$cheminVueBody = "stations.php";

		// Requête SQL corrigée avec les noms de tables corrects
		$query = "
			SELECT
				s.id AS station_id,
				s.name AS station_name,
				v.name AS ville_name,
				e.name AS epci_name,
				d.name AS dept_name,
				r.name AS region_name
			FROM stations s
			JOIN villes v ON s.ville_id = v.id
			JOIN epcis e ON v.epci_id = e.id
			JOIN depts d ON e.dept_id = d.id
			JOIN regions r ON d.reg_id = r.id
		";

		try {
			$stations = DatabaseConnection::executeQuery($query);
		} catch (PDOException $e) {
			die("Erreur SQL : " . $e->getMessage());
		}

		require('../src/Views/Template/views.php');
	}

	/**
	 * Recupère les informations d'une station dans l'api pour les envoier en une variable
	 * @param int $id
	 * @return void
	 */
	public static function infoStation(int $id): array
	{
		// Requête SQL corrigée avec les noms de tables corrects
		$requette = new Constructeur_Requette_API(
			["all"],
			["numer_sta=" . $id],
			["numero_sta"],
			"numero_sta",
			"10000"
		);
		$station = Requetteur_API::fetchData($requette, "numer_sta", "nom_sta");
		$station = $station[0];

		// Vérification de l'existence de la station
		if (empty($station)) {
			MsgRepository::newError("Erreur", "Aucune station trouvée avec cet ID.");
			return [];
		}

		return $station;
	}

	/**
	 * Affiche la page d'information sur une station
	 *
	 * @param int $id
	 * @return void
	 */
	// public static function info_station(): void
	// {
	// 	// Appel page
	// 	$titrePage = "Informations sur la station";
	// 	$cheminVueBody = "info_station.php";

	// 	$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
	// 	// Récupération des informations de la station
	// 	$station = self::infoStation($id);

	// 	if (empty($station)) {
	// 		return;
	// 	}

	// 	require('../src/Views/Template/views.php');
	// }
	#endregion

	public static function tuto(): void
	{
		$titrePage = "Tutoriel";
		$cheminVueBody = "tuto.php";
		require('../src/Views/Template/views.php');
	}
}
