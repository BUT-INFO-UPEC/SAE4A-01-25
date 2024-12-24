<?php

namespace App\Model\Classes;

use PDO;
use PDOException;
use App\Controller\Controller;

/**
 * Classe BDD
 * 
 * Gère la connexion à une base de données SQLite et fournit des méthodes pour exécuter des requêtes SQL.
 * En cas d'erreur ou de succès, des messages sont envoyés via la région Message du Controller.
 */
class BDD
{
    /**
     * @var PDO|null Instance de la connexion PDO
     */
    private ?PDO $pdo;

    /**
     * Constructeur de la classe BDD.
     * 
     * Initialise la connexion à la base de données SQLite. En cas d'échec, un message d'erreur est généré.
     */
    public function __construct()
    {
        try {
            // Chemin absolu vers la base de données SQLite
            $dbPath = __DIR__ . '/../../../database/France.db';

            // Initialisation de la connexion PDO
            $this->pdo = new PDO('sqlite:' . $dbPath, null, null, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);

            // Message de succès
            Controller::setSuccess("Connexion à la base de données établie avec succès.");
        } catch (PDOException $e) {
            // Message d'erreur via le Controller
            Controller::setError("Erreur de connexion à la base de données : " . $e->getMessage());
            exit;
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
            Controller::setError("Erreur lors de l'exécution de fetchAll : " . $e->getMessage());
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
            Controller::setError("Erreur lors de l'exécution de fetchOne : " . $e->getMessage());
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
            return $stmt->execute($params);
        } catch (PDOException $e) {
            Controller::setError("Erreur lors de l'exécution de la requête : " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Ferme explicitement la connexion à la base de données.
     */
    public function closeConnection(): void
    {
        $this->pdo = null;
        Controller::setSuccess("Connexion à la base de données fermée avec succès.");
    }
}
