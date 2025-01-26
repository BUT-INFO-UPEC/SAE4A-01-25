<?php

namespace Src\Model\DataObject;

use Src\Model\Repository\DatabaseConnection;
use PDO;

class Utilisateur extends AbstractDataObject
{
	// =======================
	//        ATTRIBUTES
	// =======================
	private ?int $id;
	private string $utilisateur_pseudo;
	private string $utilisateur_mail;
	private string $utilisateur_nom;
	private string $utilisateur_prenom;
	private ?string $utilisateur_crea;

	// =======================
	//      CONSTRUCTOR
	// =======================
	public function __construct(
		string $pseudo,
		string $mail,
		string $nom,
		string $prenom,
		?int $id = null,
		?string $crea = null
	) {
		$this->id = $id;
		$this->utilisateur_pseudo = $pseudo;
		$this->utilisateur_mail = $mail;
		$this->utilisateur_nom = $nom;
		$this->utilisateur_prenom = $prenom;
		$this->utilisateur_crea = $crea;
	}

	#region getters
	// =======================
	//      GETTERS
	// =======================
	public function getId(): ?int
	{
		return $this->id;
	}
	public function getPseudo(): string
	{
		return $this->utilisateur_pseudo;
	}

	public function getEmail(): string
	{
		return $this->utilisateur_mail;
	}

	public function getNom(): string
	{
		return $this->utilisateur_nom;
	}

	public function getPrenom(): string
	{
		return $this->utilisateur_prenom;
	}
	public function getUtilisateur_crea(): ?string
	{
		return $this->utilisateur_crea;
	}

	public function getNbPubli()
	{
		$query = "SELECT count(*) FROM Dashboards WHERE createur_id = :createur_id";
		$values = [":createur_id" => $this->getId()];
		$stmt = DatabaseConnection::executeQuery($query, $values);
		return $stmt->fetch(PDO::FETCH_NUM)[0];
	}
	#endregion

	#region setters
	public function setId($id)
	{
		$this->id = $id;
	}
	#endregion setters

	#region public methods
	// =======================
	//    PUBLIC METHODS
	// =======================
	public function formatTableau(): array
	{
		return [
			':utilisateur_id' => $this->getId(),
			':utilisateur_pseudo' => $this->utilisateur_pseudo,
			':utilisateur_mail' => $this->utilisateur_mail,
			':utilisateur_nom' => $this->utilisateur_nom,
			':utilisateur_prenom' => $this->utilisateur_prenom,
			':created_at' => $this->utilisateur_crea
		];
	}
	#endregion
}
