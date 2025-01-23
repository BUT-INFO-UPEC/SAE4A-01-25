<?php

namespace Src\Model\Repository;

use PDO;
use PDOException;
use PDOStatement;

/**
 * Classe de gestion des connexions à la base de données (CRUD).
 */
class DatabaseConnection
{
	// =======================
	//        ATTRIBUTS
	// =======================
	private static ?DatabaseConnection $instance = null;
	private PDO $pdo;

	// =======================
	//      CONSTRUCTEUR
	// =======================
	/**
	 * Constructeur privé pour empêcher l'instanciation directe.
	 */
	private function __construct()
	{
		try {
			// Connexion à la base de données SQLite
			$dbPath = __DIR__ . '/../../../database/DATABASE.db';

			// Vérifie si le fichier de la base de données existe
			if (!file_exists($dbPath)) {
				throw new PDOException("Le fichier de la base de données est introuvable : $dbPath");
			}

			// Initialisation de la connexion PDO
			$this->pdo = new PDO('sqlite:' . $dbPath, null, null, [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			]);
		} catch (PDOException $e) {
			exit("Erreur : Connexion à la base de données impossible. Détails : " . $e->getMessage());
		}
	}

	// =======================
	//    MÉTHODES STATIQUES
	// =======================

	/**
	 * Retourne l'instance PDO.
	 *
	 * @return PDO
	 */
	public static function getPdo(): PDO
	{
		return static::getInstance()->pdo;
	}

	/**
	 * Exécute une requête SQL avec des paramètres.
	 *
	 * @param string $query Requête SQL.
	 * @param array $params Paramètres de la requête.
	 * 
	 * @return PDOStatement
	 * @throws PDOException
	 */
	public static function executeQuery(string $query, array $params = []): PDOStatement
	{
		try {
			$stmt = static::getPdo()->prepare($query);
			$stmt->execute($params);
			return $stmt;
		} catch (PDOException $e) {
			throw $e;
		}
	}

	/**
	 * Récupère plusieurs enregistrements depuis la base de données.
	 * 
	 * @param string $query La requête SQL à exécuter.
	 * @param array $params Les paramètres associés à la requête SQL.
	 * 
	 * @return array Retourne un tableau contenant tous les enregistrements.
	 */
	public static function fetchAll(string $query, array $params = []): array
	{
		try {
			$stmt = static::executeQuery($query, $params);
			return $stmt->fetchAll();
		} catch (PDOException $e) {
			throw $e;
		}
	}

	/**
	 * Récupère un seul enregistrement depuis la base de données.
	 * 
	 * @param string $query La requête SQL à exécuter.
	 * @param array $params Les paramètres associés à la requête SQL.
	 * 
	 * @return array|null Retourne un tableau associatif contenant l'enregistrement ou null si aucun résultat n'est trouvé.
	 */
	public static function fetchOne(string $query, array $params = []): ?array
	{
		try {
			$stmt = static::executeQuery($query, $params);
			return $stmt->fetch() ?: null;
		} catch (PDOException $e) {
			throw $e;
		}
	}

	/**
	 * Retourne l'unique instance de la classe.
	 *
	 * @return self
	 */
	private static function getInstance(): self
	{
		if (is_null(static::$instance)) {
			static::$instance = new self();
		}
		return static::$instance;
	}
}
