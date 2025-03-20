<?php

namespace Src\Config;

/**
 * Description de la classe
 */
class db_manager
{

	// =======================
	//        ATTRIBUTES
	// =======================
	#region Attributs
	// Ajouter vos attributs ici
	#endregion Attributs

	// =======================
	//      CONSTRUCTOR
	// =======================
	public function __construct()
	{
		// Constructeur
	}

	// =======================
	//      GETTERS
	// =======================
	#region Getters
	// Ajouter vos getters ici
	#endregion Getters

	// =======================
	//      SETTERS
	// =======================
	#region Setters
	// Ajouter vos setters ici
	#endregion Setters

	// =======================
	//    PUBLIC METHODS
	// =======================
	#region Publiques
	// Ajouter vos méthodes publiques ici
	#endregion Publiques

	// =======================
	//    PRIVATE METHODS
	// =======================
	#region Privees
	// Ajouter vos méthodes privées ici
	#endregion Privees

	// =======================
	//    STATIC METHODS
	// =======================
	#region Statiques
	/**
	 * @return array
	 */
	public static function update_fixtures(): array
	{
		// parcourir le fichier Fixtures et appliquer lancer les fichiers qui ne sont pas contenus dans la table applied_fixtures, ajouter dans la table aprés application.F
		return ["dbRevamp_01", "dbRevamp_02"];
	}
	#endregion Statiques

	// =======================
	//    OVERIDES
	// =======================
	#region Overides
	// Ajouter vos méthodes overrides ici
	#endregion Overides

}
