<?php

namespace Src\Model\Repository;

use Src\Config\ConfBDD;
use PDO;
use PDOException;
use PDOStatement;

/**
 * Gestion des connexions a la BDD_ (CRUD)
 */
class DatabaseConnection
{
	// =======================
	//        ATTRIBUTS
	// =======================
	#region Attributes
	private static $instance = null;
	private $pdo;
	#endregion Attributes

	// =======================
	//      CONSTRUCTEUR
	// =======================
	/**
	 * Constructeur privé pour empêcher l'instanciation directe.
	 */
	private function __construct()
	{

		// Connexion à la base de données
		// Le dernier argument sert à ce que toutes les chaines de caractères en entrée et sortie de MySql soit dans le codage UTF-8
		$dbpath = __DIR__  . "/../../../database/DATABASE.db";
		$this->pdo = new PDO('sqlite:' . $dbpath, null, null, [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		]);
	}

	// =======================
	//    METHODES STATIQUES
	// =======================
	#region Static
	/**
	 * Retourne l'instance PDO.
	 *
	 * @return PDO
	 */
	static public function getPdo(): PDO
	{
		return static::getInstance()->pdo;
	}

	/**
	 * Exécute une requête SQL avec des paramètres.
	 *
	 * @param string $query Requête SQL.
	 * @param array $params Paramètres de la requête.
	 * @return PDOStatement
	 * @throws PDOException
	 */
	static public function executeQuery(string $query, array $params = []): PDOStatement
	{
		try {
			$pdo = static::getPdo();
			$stmt = $pdo->prepare($query);
			$stmt->execute($params);
			return $stmt;
		} catch (PDOException $e) {
			throw $e;
		}
	}

	/**
	 * GetInstance s'assure que le constructeur sera appelé une seule fois.
	 * L'unique instance crée est stockée dans l'attribut $instance
	 *
	 * @return static
	 */
	private static function getInstance()
	{
		// L'attribut statique $pdo s'obtient avec la syntaxe static::$pdo au lieu de $this->pdo pour un attribut non statique
		if (is_null(static::$instance))
			// Appel du constructeur
			static::$instance = new DatabaseConnection();
		return static::$instance;
	}
	#region Static
}
