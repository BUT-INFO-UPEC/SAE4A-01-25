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
      $check_user = UtilisateurRepository::checkUserExist($email, $mdp);

      if ($check_user) {
        // Récupération des informations utilisateur
        $user = UtilisateurRepository::getUserByMailMdp($email, $mdp);

        if ($user) {
          $_SESSION['login'] = $user['utilisateur_pseudo'];

          // cookie pour recuperer le mail (car il n'y a pas deux fois le même mail dans la table)
          ConfAPP::setCookie('CurentMail', $email);

          UtilisateurRepository::updateNbConn();


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
      $nom = $_POST['nom'] ?? null;
      $prenom = $_POST['prenom'] ?? null;
      $pseudo = $_POST['pseudo'] ?? null;
      $email = $_POST['mail'] ?? null;
      $mdp = $_POST['mdp'] ?? null;
      $confirme_mdp = $_POST['passwordConfirm'] ?? null;

      // Vérification que les champs sont remplis
      if (empty($nom) || empty($prenom) || empty($pseudo) || empty($email) || empty($mdp) || empty($confirme_mdp)) {
        $msg = new Msg("Veuillez remplir tous les champs.");
        $msg->setErrorAndRedirect(); // Utilisation de la méthode setErrorAndRedirect()
      }
      // Vérification que les mots de passe sont identiques
      elseif ($mdp !== $confirme_mdp) {
        $msg = new Msg("Les mots de passe ne correspondent pas.");
        $msg->setErrorAndRedirect();
      }
      // Vérification de l'existence de l'utilisateur
      $check_user = UtilisateurRepository::checkUserExist($email, $mdp);

      if (!$check_user) {
        $user = new Utilisateur(
          $pseudo,
          $email,
          $mdp,
          $nom,
          $prenom
        );
        $user->insertUser(); // Enregistrement de l'utilisateur dans la base de données

        // cookie pour recuperer le mail (car il n'y a pas deux fois le même mail dans la table)
        ConfAPP::setCookie('CurentMail', $email);
        UtilisateurRepository::updateNbConn();
        // msg succes
        $msg = new Msg("Inscription réussie !");
        $msg->setSuccessAndRedirect();
      } else {
        $msg = new Msg("L'utilisateur existe déjà.");
        $msg->setWarningAndRedirect();
      }
    } catch (Exception $e) {
      $msg = new Msg("Erreur lors de l'inscription : " . $e->getMessage());
      $msg->setErrorAndRedirect(); // Utilisation de la méthode setErrorAndRedirect()
    } catch (PDOException $e) {
      $msg = new Msg("Erreur lors de l'inscription : " . $e->getMessage());
      $msg->setErrorAndRedirect(); // Utilisation de la méthode setErrorAndRedirect()
    }
  }

  public static function deconnexion()
  {
    // Suppression de la session utilisateur
    session_unset();
    ConfAPP::unSetCookie('CurentMail');
    UtilisateurRepository::updateLastConn();
    $msg = new Msg("Vous êtes désormais déconnecté !");
    $msg->setSuccess();
    header("Location: ?controller=ControllerGeneral");
  }

  public static function profile()
  {
    $titrePage = "Profile";
    $cheminVueBody = "profil.php";
    $user = UtilisateurRepository::getUser();
    require('../src/Views/Template/views.php');
  }

  #endregion

  public static function test() {
    $cheminVueBody = "test.php";
    $titrePage = "Test";
    
    require('../src/Views/Template/views.php');
  }
}
