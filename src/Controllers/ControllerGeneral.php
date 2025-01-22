<?php

namespace Src\Controllers;

use Exception;
use PDOException;
use Src\Config\ConfAPP;
use Src\Model\DataObject\Msg;
use Src\Model\DataObject\Utilisateur;
use Src\Model\Repository\UtilisateurRepository;

class ControllerGeneral extends AbstractController
{
	static public function default(): void
	{
		ControllerGeneral::home();
	}

	static function getActionsList(): array
	{
		return array('Accueil' => 'action=home');
	}

	// =======================
	//    ENTRY METHODS
	// =======================
	#region entry
	/**
	 * Page d'accueil
	 * 
	 * @return void
	 */
	static public function home(): void
	{
		$titrePage = "Salutations";
		$cheminVueBody = "home.php";
		require('../src/Views/Template/views.php');
	}

	public static function carte_region()
	{
		$titrePage = "Carte Regions";
		$cheminVueBody = "carte_regions.php";
		require('../src/Views/Template/views.php');
	}
	#endregion entry

	#region utilisateur
	/**
	 * Summary of signIn
	 * @return void
	 * 
	 * Permet à l'utilisateur de se connecter
	 * en rentrant dans le formulaire de connection :
	 * - son adresse email
	 * - son mot de passe
	 */
	public static function signIn()
	{
		try {
			$email = $_POST['email'];
			$mdp = $_POST['password'];

			$check_mdp = UtilisateurRepository::checkUserMailMdp(
				$email,
				$mdp
			);
			if ($check_mdp) {
				// connexion ok
				$user = UtilisateurRepository::getUserByMailMdp($email, $mdp);
				$_SESSION['login'] = $user['utilisateur_pseudo'];
				setcookie('CurentLogin', $_SESSION['login'], ConfAPP::tCookies);
			}
			$msg = new Msg("Connexion réussie");
			$msg->setSuccess();
		} catch (Exception $e) {
			$msg = new Msg("Erreur de connexion");
			$msg->setErrorAndRedirect();
		} catch (PDOException $e) {
			$msg = new Msg("Erreur de connexion");
			$msg->setErrorAndRedirect();
		}
	}

	// public static function signUp() {
	//   try {
	//     $pseudo = $_POST['pseudo'];
	//     $email = $_POST['email'];
	//     $mdp = $_POST['password'];
	//     $check_pswd = $_POST['passwordConfirm'];
	//     $check_mdp = UtilisateurRepository::checkUserMailMdp($email, $mdp);
	//     if ($check_mdp) {
	//       $msg = new Msg("Adresse email déjà utilisée");
	//       $msg->setErrorAndRedirect();
	//     } else {
	//       if ($mdp == $check_pswd) {
	//         // $user = new Utilisateur()
	//         // $msg = new Msg("Inscription réussie");
	//       }
	//     }
	//   }
	// }
}
