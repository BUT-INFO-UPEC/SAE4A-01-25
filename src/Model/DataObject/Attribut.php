<?php

namespace Src\Model\DataObject;

use Src\Model\DataObject\AbstractDataObject;

/** Instance d'un attribut proposées par l'application lors d'une analyse de données pour un composant d'un dashboard
 */
class Attribut extends AbstractDataObject
{
	#region Attributs
	// =======================
	//        ATTRIBUTES
	// =======================

	private int $id;
	private string $type_val;
	private string $cle;
	private string $nom;
	private string $unite;
	private string $description;
	private string $exemple;
	#endregion Attributs

	// =======================
	//      CONSTRUCTOR
	// =======================

	function __construct(int $id, string $type_val, string $cle, string $nom, ?string $unite, ?string $description, ?string $exemple)
	{
		$this->id = $id;
		$this->type_val = $type_val;
		$this->cle = $cle;
		$this->nom = $nom;
		$this->unite = $unite ? $unite : " valeur unitaire";
		$this->description = $description ? $description : "Description manquante.";
		$this->exemple = $exemple ? $exemple : "Exemple manquant";
	}

	#region Getters
	// =======================
	//      GETTERS
	// =======================
	
	/** L'identifiant de l'attribut dans la BDD
	 * 
	 * @return int
	 */
	function get_id(): int
	{
		return $this->id;
	}

	/** Le type de valeur que l'API retourne quand il est reqiété pour cet attribut
	 * 
	 * @return string
	 */
	function get_type_val(): string
	{
		return $this->type_val;
	}

	/** La clé a reporter a l'API pour récupérer les valeurs de cet attribut
	 * 
	 * @return string
	 */
	function get_cle(): string
	{
		return $this->cle;
	}

	/** Le nom de l'attribut lors de l'affichage utilisateur
	 * 
	 * @return string
	 */
	function get_nom(): string
	{
		return $this->nom;
	}

	/** L'unitée des valeurs que l'attribut renvoie
	 * 
	 * @return string
	 */
	function get_unite(): string
	{
		return $this->unite;
	}

	/** La description de l'attribut pour explication des données retournées
	 * 
	 * @return string
	 */
	function get_description(): string
	{
		return $this->description;
	}

	/** Un exemple des données retournées par lAPI
	 * 
	 * @return string
	 */
	function get_exemple(): string
	{
		return $this->exemple;
	}
	#endregion Getters

	#region Overides
	// =======================
	//    OVERIDES
	// =======================
	
	public function formatTableau(): array
	{
		return [
			":id" => $this->get_id()
		];
	}


	public function __toString()
	{
		return "new Attribut(" . ($this->id ?? 'null') . ", '" . $this->type_val . "', '" . $this->cle . "', '" . $this->nom . "', '" . $this->unite . "', '" . $this->description . "', '" . $this->exemple . "')";
	}
	#endregion Overides
}
