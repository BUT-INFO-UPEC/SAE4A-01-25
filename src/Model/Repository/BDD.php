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
   * Initialise la connexion à la base de données SQLite. En cas d'échec, une exception est levée.
   */
  public function __construct()
  {
    try {
      // Chemin absolu vers la base de données SQLite
      $dbPath = __DIR__ . '/../../../assets/database/France.db';

      // Vérifie si le fichier de base de données existe
      if (!file_exists($dbPath)) {
        throw new PDOException("Le fichier de base de données est introuvable : $dbPath");
      }

      // Initialisation de la connexion PDO
      $this->pdo = new PDO("sqlite:$dbPath");
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
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
      $this->handleError("Erreur lors de fetchAll : " . $e->getMessage());
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
      return $stmt->fetch() ?: null;
    } catch (PDOException $e) {
      $this->handleError("Erreur lors de fetchOne : " . $e->getMessage());
      return null;
    }
  }

  /**
   * Exécute une requête SQL (INSERT, UPDATE, DELETE).
   * 
   * @param string $query La requête SQL à exécuter.
   * @param array $params Les paramètres associés à la requête SQL.
   * 
   * @return bool Retourne true si la requête a réussi, false sinon.
   */
  public function execute(string $query, array $params = []): bool
  {
    try {
      $stmt = $this->pdo->prepare($query);
      return $stmt->execute($params);
    } catch (PDOException $e) {
      $this->handleError("Erreur lors de l'exécution de la requête : " . $e->getMessage());
      return false;
    }
  }

  /**
   * Ferme explicitement la connexion à la base de données.
   */
  public function closeConnection(): void
  {
    $this->pdo = null;
  }

  /**
   * Gère les erreurs et les enregistre dans les logs PHP.
   * 
   * @param string $message Le message d'erreur.
   */
  private function handleError(string $message): void
  {
    error_log($message);
  }
}
