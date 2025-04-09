<?php

namespace Src\Config\ServerConf;

use InvalidArgumentException;
use PDO;
use PDOException;
use PDOStatement;
use Src\Config\Utils\LogInstance;
use Src\Config\Utils\SessionManagement;

/**
 * Classe de gestion des connexions à la base de données (CRUD).
 */
class DatabaseConnection
{
	#region attributes
	// =======================
	//        ATTRIBUTS
	// =======================

	private static ?DatabaseConnection $instance = null;
	private PDO $pdo;
	#endregion attributes

	// =======================
	//      CONSTRUCTEUR
	// =======================
	/**
	 * Constructeur privé pour empêcher l'instanciation directe.
	 */
	private function __construct()
	{
		try {
			$options = [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			];

			switch (ServerParameters::$typeSgbd) {
				case 'mysql':
					$dsn = "mysql:host=" . ServerParameters::$hote .
						";dbname=" . ServerParameters::$base .
						";charset=utf8mb4;port=" . ServerParameters::$port;
					$this->pdo = new PDO($dsn, ServerParameters::$utilisateur, ServerParameters::$motDePasse, $options);
					break;

				case 'pgsql':
					$dsn = "pgsql:host=" . ServerParameters::$hote .
						";dbname=" . ServerParameters::$base .
						";port=" . ServerParameters::$port;
					$this->pdo = new PDO($dsn, ServerParameters::$utilisateur, ServerParameters::$motDePasse, $options);
					break;

				case 'sqlite':
					$dbPath = ServerParameters::$cheminDb;
					if (!file_exists($dbPath)) {
						throw new PDOException("Le fichier de la base de données est introuvable : $dbPath");
					}
					$dsn = "sqlite:" . $dbPath;
					$this->pdo = new PDO($dsn, null, null, $options);
					break;

				default:
					throw new InvalidArgumentException("Type de SGBD non supporté : " . ServerParameters::$typeSgbd);
			}
		} catch (PDOException $e) {
			exit("Erreur : Connexion à la base de données impossible. Détails : " . $e->getMessage());
		}
	}

	#region static
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
			//SessionManagement::get_curent_log_instance()->new_log("Requette a la BDD : $query -> paramètres : " . var_export($params, true), LogInstance::GREY);
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
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
			return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
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

	/** Récupère la totalité des informations de la table
	 * 
	 * @param string $table
	 * 
	 * @return array
	 */
	public static function getTable(string $table): array
	{
		$query = "SELECT * FROM $table";
		return self::fetchAll($query);
	}
	#endregion static
}
