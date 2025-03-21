<?php

namespace Src\Model\DataObject;

use Src\Config\ServerConf\DatabaseConnection;
use PDO;

class Utilisateur extends AbstractDataObject
{
	#region attributs
	// =======================
	//        ATTRIBUTES
	// =======================

	private ?int $id;
	private string $utilisateur_pseudo;
	private string $utilisateur_mail;
	private string $utilisateur_nom;
	private string $utilisateur_prenom;
	private ?string $utilisateur_crea;
	#endregion attributs

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

	/** Récupère l'identifiant de l'utilisateur dans la BDD
	 * 
	 * @return int|null
	 */
	public function getId(): ?int
	{
		return $this->id;
	}

	/** Récupère le pseudonyme de l'utilisateur
	 * 
	 * @return string
	 */
	public function getPseudo(): string
	{
		return $this->utilisateur_pseudo;
	}

	/** récupère l'email de l'tuilisateur
	 * 
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->utilisateur_mail;
	}

	/** Récupère le nom de l'utilisateur
	 * 
	 * @return string
	 */
	public function getNom(): string
	{
		return $this->utilisateur_nom;
	}

	/** Récupère le prénom de l'utilisateur
	 * 
	 * @return string
	 */
	public function getPrenom(): string
	{
		return $this->utilisateur_prenom;
	}

	/** Retourne la date de création de l'utilisateurs
	 * 
	 * @return string|null
	 */
	public function getUtilisateur_crea(): ?string
	{
		return $this->utilisateur_crea;
	}

	/** Retourne le nombre de dashboard dont l'utilisateur est l'auteur
	 * 
	 * @return int
	 */
	public function getNbPubli(): int
	{
		$query = "SELECT count(*) FROM Dashboards WHERE createur_id = :createur_id";
		$values = [":createur_id" => $this->getId()];
		$stmt = DatabaseConnection::executeQuery($query, $values);
		return $stmt->fetch(PDO::FETCH_NUM)[0];
	}
	#endregion

	#region setters
	// =======================
	//      SETTERS
	// =======================

	/** Change l'identifiant de l'utilisateur
	 * 
	 * @param mixed $id
	 * 
	 * @return void
	 */
	public function setId($id):void
	{
		$this->id = $id;
	}
	#endregion setters

	#region public methods
	// =======================
	//    OVERIDES
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
