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
  public static function connexion()
  {
    try {
      // Vérification des données envoyées par le formulaire
      $email = trim($_POST['email'] ?? '');
      $mdp = trim($_POST['password'] ?? '');

      // Vérification que les champs sont remplis
      if (empty($email) || empty($mdp)) {
        $msg = new Msg("Veuillez remplir tous les champs.");
        $msg->setErrorAndRedirect(); // Utilisation de la méthode setErrorAndRedirect()
        return;
      }

      // Vérification des identifiants
      $check_mdp = UtilisateurRepository::checkUserExist($email, $mdp);

      if ($check_mdp) {
        // Récupération des informations utilisateur
        $user = UtilisateurRepository::getUserByMailMdp($email, $mdp);

        if ($user) {
          $_SESSION['login'] = $user['utilisateur_pseudo'];
          ConfAPP::setCookie('CurentLogin', $_SESSION['login']);
          // Message de succès et redirection
          $msg = new Msg("Connexion réussie.");
          $msg->setSuccessAndRedirect(); // Utilisation de la méthode setSuccessAndRedirect()
        } else {
          $msg = new Msg("Utilisateur introuvable.");
          $msg->setErrorAndRedirect(); // Utilisation de la méthode setErrorAndRedirect()
        }
      } else {
        $msg = new Msg("Identifiants incorrects.");
        $msg->setErrorAndRedirect(); // Utilisation de la méthode setErrorAndRedirect()
      }
    } catch (PDOException $e) {
      $msg = new Msg("Erreur lors de la connexion à la base de données : " . $e->getMessage());
      $msg->setErrorAndRedirect(); // Utilisation de la méthode setErrorAndRedirect()
    } catch (Exception $e) {
      $msg = new Msg("Erreur : " . $e->getMessage());
      $msg->setErrorAndRedirect(); // Utilisation de la méthode setErrorAndRedirect()
    }
  }

  public static function inscription()
  {
    try {
      // Vérification des données envoyées par le formulaire
      $nom = trim($_POST['signup-nom'] ?? '');
      $prenom = trim($_POST['signup-prenom'] ?? '');
      $pseudo = trim($_POST['signup-pseudo'] ?? '');
      $email = trim($_POST['signup-mail'] ?? '');
      $mdp = trim($_POST['signup-mdp'] ?? '');
      $check_pswd = trim($_POST['passwordConfirm'] ?? '');

      // Vérification que les champs sont remplis
      if (empty($pseudo) || empty($email) || empty($mdp) || empty($check_pswd)) {
        $msg = new Msg("Veuillez remplir tous les champs.");
        $msg->setErrorAndRedirect(); // Utilisation de la méthode setErrorAndRedirect()
        return;
      }

      // Vérification que les mots de passe correspondent
      if ($mdp !== $check_pswd) {
        $msg = new Msg("Les mots de passe ne correspondent pas.");
        $msg->setErrorAndRedirect(); // Utilisation de la méthode setErrorAndRedirect()
        return;
      }

      // Vérification si l'email est déjà utilisé
      if (UtilisateurRepository::checkUserExist($email, $mdp)) {
        $msg = new Msg("Cette adresse email est déjà utilisée.");
        $msg->setErrorAndRedirect(); // Utilisation de la méthode setErrorAndRedirect()
        return;
      }

      // Création du nouvel utilisateur
      $user = new Utilisateur($nom, $prenom, $pseudo, $email, $mdp);
      $user->insertUser();

      // Connexion automatique après l'inscription
      $_SESSION['login'] = $pseudo;
      ConfAPP::setCookie('CurentLogin', $_SESSION['login']);

      // Message de succès et redirection
      $msg = new Msg("Inscription réussie !");
      $msg->setSuccessAndRedirect(); // Utilisation de la méthode setSuccessAndRedirect()
    } catch (PDOException $e) {
      $msg = new Msg("Erreur lors de l'inscription : " . $e->getMessage());
      $msg->setErrorAndRedirect(); // Utilisation de la méthode setErrorAndRedirect()
    } catch (Exception $e) {
      $msg = new Msg("Erreur : " . $e->getMessage());
      $msg->setErrorAndRedirect(); // Utilisation de la méthode setErrorAndRedirect()
    }
  }
}
