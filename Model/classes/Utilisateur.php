<?php
session_start();
class Utilisateur
{
    // =======================
    //        ATTRIBUTES
    // =======================
    private $utilisateur_id;
    private $utilisateur_nom;
    private $utilisateur_pswd;
    private $utilisateur_surnom;

    // =======================
    //      CONSTRUCTOR
    // =======================
    public function __construct($nom, $pswd, $surnom)
    {
        $this->utilisateur_nom = $nom;
        $this->utilisateur_pswd = $pswd;
        $this->utilisateur_surnom = $surnom;
    }

    // =======================
    //      GETTERS
    // =======================
    public function getName()
    {
        return $this->utilisateur_nom;
    }
    public function getEmail()
    {
        return $this->utilisateur_surnom;
    }
    public function getUsername()
    {
        return $this->utilisateur_surnom;
    }
    public function getPassword()
    {
        return $this->utilisateur_pswd;
    }

    // =======================
    //      SETTERS
    // =======================
    public function setName(string $nom)
    {
        $this->utilisateur_nom = $nom;
    }
    public function setEmail(string $email)
    {
        $this->utilisateur_surnom = $email;
    }
    public function setUsername(string $username)
    {
        $this->utilisateur_surnom = $username;
    }
    public function setPassword(string $password)
    {
        $this->utilisateur_pswd = $password;
    }

    // =======================
    //    PUBLIC METHODS
    // =======================
    /**
     * Méthode pour insérer un utilisateur dans la base de données SQLite
     */
    public function insertUser(
        $utilisateur_nom,
        $utilisateur_pswd,
        $utilisateur_surnom,
        $utilisateur_ami
    ) {
        try {
            $pdo = BaseDeDonnees::getDb();
            $sql = "INSERT INTO utilisateur (utilisateur_nom, utilisateur_pswd, utilisateur_surnom, utilisateur_ami)
                    VALUES (:nom, :pswd, :surnom, :ami)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            echo "Utilisateur '{$this->utilisateur_nom}' inséré avec succès.<br>";
        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion : " . $e->getMessage() . "<br>";
        }
    }
}
