<?php

namespace Src\Config\ServerConf;

/**
 * 				LE SEUL SGBD PRIS EN CHARGE POUR L'INSTANT EST SQLITE !!!!!!!!!!!
 * 
 * la compatibulité entre les SGBDs n'a pas encore été réalisée
 */
class ServerParameters
{

	#region Attributs
	// =======================
	//        ATTRIBUTES
	// =======================
	// Type de SGBD : sqlite, mysql, pgsql...
	public static string $typeSgbd = 'sqlite';

	// Paramètres communs pour MySQL/PGSQL
	public static string $hote = 'localhost';
	public static int $port = 3306;
	public static string $base = 'dev_meteoscop';
	public static string $utilisateur = 'root';
	public static string $motDePasse = '';

	// Paramètre spécifique pour SQLite
	public static string $cheminDb = __DIR__ . '/../../../database/DATABASE.db';
	#endregion Attributs

	// =======================
	//      CONSTRUCTOR
	// =======================
	public function __construct()
	{
		// Constructeur
	}

	#region Getters
	// =======================
	//      GETTERS
	// =======================
	// Ajouter vos getters ici
	#endregion Getters

	#region Setters
	// =======================
	//      SETTERS
	// =======================
	// Ajouter vos setters ici
	#endregion Setters

	#region Publiques
	// =======================
	//    PUBLIC METHODS
	// =======================
	// Ajouter vos méthodes publiques ici
	#endregion Publiques

	#region Privees
	// =======================
	//    PRIVATE METHODS
	// =======================
	// Ajouter vos méthodes privées ici
	#endregion Privees

	#region Statiques
	// =======================
	//    STATIC METHODS
	// =======================
	// Ajouter vos méthodes statiques ici
	#endregion Statiques

	#region Overides
	// =======================
	//    OVERIDES
	// =======================
	// Ajouter vos méthodes overrides ici
	#endregion Overides

}
