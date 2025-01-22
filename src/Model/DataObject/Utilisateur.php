<?php

namespace Src\Model\DataObject;

use PDOException;
use Src\Model\Repository\BDD;

class Utilisateur
{
	// =======================
	//        ATTRIBUTES
	// =======================
	private string $utilisateur_nom;
	private string $utilisateur_prenom;
	private string $utilisateur_pseudo;
	private string $utilisateur_mdp;
	private string $utilisateur_mail;

	// =======================
	//      CONSTRUCTOR
	// =======================
	public function __construct(
		string $nom,
		string $prenom,
		string $pseudo,
		string $mail,
		string $mdp
	) {
		$this->utilisateur_pseudo = $pseudo;
		$this->utilisateur_mail = $mail;
		$this->utilisateur_mdp = $mdp;
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
			$pdo = new BDD();

			// Préparation de la requête SQL
			$sql = "INSERT INTO utilisateur (utilisateur_pseudo, utilisateur_mdp, utilisateur_mail, utilisateur_nom, $utilisateur_prenom)
                    VALUES (:pseudo, :mdp, :mail, :nom, :prenom)";


			// Exécution de la requête avec les paramètres
			$pdo->execute($sql, [
				':pseudo' => $this->utilisateur_pseudo,
				':mdp' => $this->utilisateur_mdp,
				':mail' => $this->utilisateur_mail,
				':nom' => $this->utilisateur_nom,
				':prenom' => $this->utilisateur_prenom
			]);

			// Message de succès
			$_SESSION['success'] = "Utilisateur {$this->utilisateur_pseudo} a été ajouté avec succès.";
		} catch (PDOException $e) {
			// Gestion des erreurs
			$_SESSION['error'] = "Erreur lors de l'insertion : " . $e->getMessage();
		}
	}
}
