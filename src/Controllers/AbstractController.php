<?php
abstract class AbstractController {
  /**
  * Méthode par défaut standardisée
  * 
  * @return void Redirige vers l'action par défaut du controleur
  */
  abstract static function default(): void;
  
/**
 * @return array Liste des noms des actions du controleur et leur mots clé associés
 */
  abstract static function getActionsList(): array;
}
?>