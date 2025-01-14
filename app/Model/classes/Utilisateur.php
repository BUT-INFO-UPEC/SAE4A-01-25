<?php

namespace App\Model\Classes;

use PDOException;

class Utilisateur
{
    // =======================
    //        ATTRIBUTES
    // =======================
    private int $utilisateur_id;
    private string $utilisateur_pseudo;
    private string $utilisateur_mdp;
    private string $utilisateur_mail;
    private array $utilisateur_amis;

    // =======================
    //      CONSTRUCTOR
    // =======================
    public function __construct(string $pseudo, string $mail, string $mdp, array $amis = [])
    {
        $this->utilisateur_pseudo = $pseudo;
        $this->utilisateur_mail = $mail;
        $this->utilisateur_mdp = $mdp;
        $this->utilisateur_amis = $amis;
    }

    // =======================
    //      GETTERS
    // =======================
    public function getPseudo(): string
    {
        return $this->utilisateur_pseudo;
    }

    public function getEmail(): string
    {
        return $this->utilisateur_mail;
    }

    public function getPassword(): string
    {
        return $this->utilisateur_mdp;
    }

    public function getAmis(): array
    {
        return $this->utilisateur_amis;
    }

    // =======================
    //      SETTERS
    // =======================
    public function setPseudo(string $pseudo): void
    {
        $this->utilisateur_pseudo = $pseudo;
    }

    public function setEmail(string $mail): void
    {
        $this->utilisateur_mail = $mail;
    }

    public function setPassword(string $mdp): void
    {
        $this->utilisateur_mdp = $mdp;
    }

    public function setAmis(array $amis): void
    {
        $this->utilisateur_amis = $amis;
    }

    // =======================
    //    PUBLIC METHODS
    // =======================
    /**
     * Méthode pour insérer un utilisateur dans la base de données SQLite
     */
    public function insertUser(): void
    {
        try {
            // On récupère l'instance PDO depuis la classe BaseDeDonnees
            $pdo = BDD::getDb();

            // Préparation de la requête SQL
            $sql = "INSERT INTO utilisateur (utilisateur_pseudo, utilisateur_mdp, utilisateur_mail, utilisateur_amis)
                    VALUES (:pseudo, :mdp, :mail, :amis)";
            $stmt = $pdo->prepare($sql);

            // Sérialisation du tableau des amis pour le stocker en base
            $amis_serialises = json_encode($this->utilisateur_amis);

            // Exécution de la requête avec les paramètres
            $stmt->execute([
                ':pseudo' => $this->utilisateur_pseudo,
                ':mdp' => $this->utilisateur_mdp,
                ':mail' => $this->utilisateur_mail,
                ':amis' => $amis_serialises
            ]);

            // Message de succès
            $_SESSION['success'] = "Utilisateur {$this->utilisateur_pseudo} a été ajouté avec succès.";
        } catch (PDOException $e) {
            // Gestion des erreurs
            $_SESSION['error'] = "Erreur lors de l'insertion : " . $e->getMessage();
        }
    }
}
