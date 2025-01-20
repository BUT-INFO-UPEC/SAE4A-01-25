<?php
require_once __DIR__ . "/AbstractController.php";


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
  #endregion entry
}
