<?php

namespace App\Model\Classes;

use PDO, PDOException;

require_once __DIR__ . '/User.php';

/**
 * Classe BaseDeDonnees
 * 
 * Cette classe est responsable de la gestion des interactions avec la base de données SQLite.
 */
class BDD
{
    // =======================
    //        ATTRIBUTS
    // =======================
    /**
     * Instance unique de la connexion PDO.
     * 
     * @var PDO|null
     */
    private static $pdo = null;

    // =======================
    //    METHODES PUBLIQUES
    // =======================

    /**
     * Méthode statique pour obtenir une connexion unique à la base de données.
     * Si la connexion n'existe pas encore, elle est créée.
     * 
     * @return PDO|null Instance de la connexion à la base de données ou null en cas d'erreur.
     */
    public static function getDb()
    {
        // Vérifie si la connexion n'a pas encore été initialisée
        if (self::$pdo === null) {
            // Chemin vers le fichier de la base de données SQLite
            $dbPath = __DIR__ . '/../../database/France.db';

            try {
                // Création d'une connexion PDO avec SQLite
                self::$pdo = new PDO("sqlite:" . $dbPath);

                // Configuration du mode de gestion des erreurs pour PDO
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                // Gestion des erreurs de connexion
                echo "Erreur de connexion à la base de données : " . $e->getMessage();
                return null;
            }
        }
        // Retourne l'instance de connexion
        return self::$pdo;
    }

    /**
     * Exécute une requête SQL et retourne tous les résultats sous forme de tableau associatif.
     * 
     * @param string $query La requête SQL à exécuter.
     * @param array $params Paramètres à lier à la requête SQL.
     * 
     * @return array Tableau des résultats. Retourne un tableau vide si aucun résultat.
     */
    public function fetchAll(string $query, array $params = []): array
    {
        // Préparation et exécution de la requête
        $stmt = self::getDb()->prepare($query);
        $stmt->execute($params);

        // Récupération de tous les résultats
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Exécute une requête SQL et retourne un seul résultat sous forme de tableau associatif.
     * 
     * @param string $query La requête SQL à exécuter.
     * @param array $params Paramètres à lier à la requête SQL.
     * 
     * @return array|null Tableau associatif représentant le résultat ou null si aucun résultat.
     */
    public function fetchOne(string $query, array $params = []): ?array
    {
        // Préparation et exécution de la requête
        $stmt = self::getDb()->prepare($query);
        $stmt->execute($params);

        // Récupération du premier résultat
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Exécute une requête SQL (INSERT, UPDATE, DELETE) et retourne un booléen indiquant le succès de l'opération.
     * 
     * @param string $query La requête SQL à exécuter.
     * @param array $params Paramètres à lier à la requête SQL.
     * 
     * @return bool True si l'exécution a réussi, False sinon.
     */
    public function execute(string $query, array $params = []): bool
    {
        // Préparation de la requête
        $stmt = self::getDb()->prepare($query);

        // Exécution de la requête et retour du succès
        return $stmt->execute($params);
    }
}
