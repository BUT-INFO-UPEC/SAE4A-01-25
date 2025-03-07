<?php

namespace Src\Model\DataObject;

/**Classe mêre de toutes les données dynamiques du site pour structurer la gestion des données et eviter la redondance.
 */
abstract class AbstractDataObject
{
	#region Attributs
	// =======================
	//        ATTRIBUTES
	// =======================
	#endregion Attributs

	// =======================
	//      CONSTRUCTOR
	// =======================

	#region Getters
	// =======================
	//      GETTERS
	// =======================
	#endregion Getters

	#region Stters
	// =======================
	//      SETTERS
	// =======================
	#endregion Stters

	#region Publiques
	// =======================
	//    PUBLIC METHODS
	// =======================
	#endregion Publiques

	#region Privees
	// =======================
	//    PRIVATE METHODS
	// =======================
	#endregion Privees

	#region Statiques
	// =======================
	//    STATIC METHODS
	// =======================
	#endregion Statiques

	#region abstraites
	// =======================
	//    ABSTRACT METHODS
	// =======================
	/**
	 * Mets en forme l'objets en extrayant ses données au format tableau pour enregistrement dans la BDD
	 * 
	 * @return array
	 */
	public abstract function formatTableau(): array;
	#endregion abstraites

	#region Overides
	// =======================
	//    OVERIDES
	// =======================
	#endregion Overides
}
