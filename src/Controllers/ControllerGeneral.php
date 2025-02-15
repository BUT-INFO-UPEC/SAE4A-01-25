<?php

namespace Src\Controllers;

use Exception;
use PDOException;
use Src\Config\MsgRepository;
use Src\Model\DataObject\Utilisateur;
use Src\Model\Repository\UtilisateurRepository;
use Src\Config\UserManagement;

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

	#region POST
	// =======================
	//    POST METHODS
	// =======================

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

				MsgRepository::newSuccess("Connexion réussie.");
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
		session_unset();
		MsgRepository::newSuccess("Déconnexion réussie !", "Vous etes maintenant déconnécté(e)");
	}

	/** Retourne la page d'information sur l'utilisateur connécté
	 * 
	 * @return void
	 */
	public static function profile(): void
	{
		if (UserManagement::getUser() == null)
			// Erreur + rediréction si l'utilisateur n'est pas connécté
			MsgRepository::newWarning('Non connécté', 'Vous devez etre enregistré(e) pour pouvoir enregistrer un dashboard', "?action=home");

		// Appel page
		$titrePage = "Profile";
		$cheminVueBody = "profil.php";
		$user = $_SESSION['user'];
		require('../src/Views/Template/views.php');
	}
	#endregion user
	#endregion POST
}
