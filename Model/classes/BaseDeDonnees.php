<?php

require_once __DIR__ . '/User.php';

class BaseDeDonnees
{
    // =======================
    //        ATTRIBUTES
    // =======================
    private static $pdo = null;

    // =======================
    //    PUBLIC METHODS
    // =======================
    /**
     * Méthode pour obtenir une connexion à la base de données
     *
     * @return PDO|null
     */
    public static function getDb()
    {
        if (self::$pdo === null) {
            $dbPath = __DIR__ . '/database/France.db'; // Chemin vers la base de données

            try {
                self::$pdo = new PDO("sqlite:" . $dbPath);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Erreur de connexion à la base de données : " . $e->getMessage();
                return null;
            }
        }
        return self::$pdo;
    }
}
