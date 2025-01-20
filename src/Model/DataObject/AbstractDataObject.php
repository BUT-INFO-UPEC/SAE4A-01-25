<?php

/**Classe mêre de toutes les données dynamiques du site pour eviter la redondance.
 */
abstract class AbstractDataObject
{
  // =======================
  //        ATTRIBUTES
  // =======================
  #region Attributs
  #endregion Attributs

  // =======================
  //      CONSTRUCTOR
  // =======================

  // =======================
  //      GETTERS
  // =======================
  #region Getters
  #endregion Getters

  // =======================
  //      SETTERS
  // =======================
  #region Stters
  #endregion Stters

  // =======================
  //    PUBLIC METHODS
  // =======================
  #region Publiques
  #endregion Publiques

  // =======================
  //    PRIVATE METHODS
  // =======================
  #region Privees
  #endregion Privees

  // =======================
  //    STATIC METHODS
  // =======================
  #region Statiques
  #endregion Statiques

  // =======================
  //    ABSTRACT METHODS
  // =======================
  #region abstraites
  /**
   * Mets en forme l'objets en extrayant ses données au format tableau pour enregistrement dans la BDD
   * 
   * @return array
   */
  public abstract function formatTableau(): array;
  #endregion abstraites

  // =======================
  //    OVERIDES
  // =======================
  #region Overides
  #endregion Overides
}
