<?php

namespace Src\Model\Repository;

use PDO;
use PDOException;

/**
 * Classe BDD
 * 
 * Gère la connexion à une base de données SQLite et fournit des méthodes pour exécuter des requêtes SQL.
 */
class BDD
{
	/**
	 * @var PDO|null Instance de la connexion PDO
	 */
	private ?PDO $pdo = null;

	/**
	 * Constructeur de la classe BDD.
	 * 
	 * Initialise la connexion à la base de données SQLite. En cas d'échec, un message d'erreur est généré.
	 */
	public function __construct()
	{
		try {
			// Chemin absolu vers la base de données SQLite
			$dbPath = __DIR__ . '/../../database/France.db';

			// Vérifie si le fichier de base de données existe
			if (!file_exists($dbPath)) {
				throw new PDOException("Le fichier de base de données est introuvable : $dbPath");
			}

			// Initialisation de la connexion PDO
			$this->pdo = new PDO('sqlite:' . $dbPath, null, null, [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
			]);

			// // Message de succès
			// if (class_exists('\App\Controller\Controller')) {
			//     Controller::setSuccess("Connexion à la base de données établie avec succès.");
			// }
		} catch (PDOException $e) {
			// Gestion des erreurs de connexion
			// if (class_exists('\App\Controller\Controller')) {
			//     Controller::setError("Erreur de connexion à la base de données : " . $e->getMessage());
			// }
			exit("Erreur : Connexion à la base de données impossible. Détails : " . $e->getMessage());
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
	public function fetchAll(string $query, array $params = []): array
	{
		try {
			$stmt = $this->pdo->prepare($query);
			$stmt->execute($params);
			return $stmt->fetchAll();
		} catch (PDOException $e) {
			$this->handleError("Erreur lors de l'exécution de fetchAll : " . $e->getMessage());
			return [];
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
	public function fetchOne(string $query, array $params = []): ?array
	{
		try {
			$stmt = $this->pdo->prepare($query);
			$stmt->execute($params);
			$result = $stmt->fetch();
			return $result ?: null;
		} catch (PDOException $e) {
			$this->handleError("Erreur lors de l'exécution de fetchOne : " . $e->getMessage());
			return null;
		}
	}

	/**
	 * Exécute une requête SQL (INSERT, UPDATE, DELETE).
	 * 
	 * @param string $query La requête SQL à exécuter.
	 * @param array $params Les paramètres associés à la requête SQL.
	 * 
	 * @return int Retourne le nombre de lignes affectées par la requête.
	 */
	public function execute(string $query, array $params = []): int
	{
		try {
			$stmt = $this->pdo->prepare($query);
			$stmt->execute($params);
			return $stmt->rowCount();
		} catch (PDOException $e) {
			$this->handleError("Erreur lors de l'exécution de la requête : " . $e->getMessage());
			return 0;
		}
	}

	/**
	 * Ferme explicitement la connexion à la base de données.
	 */
	public function closeConnection(): void
	{
		$this->pdo = null;
		if (class_exists('\App\Controller\Controller')) {
			// Controller::setSuccess("Connexion à la base de données fermée avec succès.");
		}
	}

	/**
	 * Gère les erreurs et envoie un message via le Controller si disponible.
	 * 
	 * @param string $message Le message d'erreur.
	 */
	private function handleError(string $message): void
	{
		if (class_exists('\App\Controller\Controller')) {
			// Controller::setError($message);
		} else {
			error_log($message);
		}
	}
}
