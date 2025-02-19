<?php

namespace Src\Model\DataObject;

use Src\Model\DataObject\AbstractDataObject;

/** Instance d'une aggregations proposées par l'application lors d'une analyse de données pour un composant d'un dashboard
 */
class Groupping extends AbstractDataObject
{
	#region Attributs
	// =======================
	//        ATTRIBUTES
	// =======================

	private int $id;
	private string $nom;
	private string $type;
	private string $cle;
	#endregion attributs

	// =======================
	//      CONSTRUCTOR
	// =======================
	function __construct(int $id, string $nom, string $type, string $cle)
	{
		$this->id = $id;
		$this->nom = $nom;
		$this->type = $type;
		$this->cle = $cle;
	}

	#region getters
	// =======================
	//      GETTERES
	// =======================

	/** L'identifiant du grouppement dans la BDD
	 * 
	 * @return int
	 */
	function get_id(): int
	{
		return $this->id;
	}

	/** Le nom du groupement, décrivant le type de séparation réalisé pour l'analyse
	 * 
	 * @return string
	 */
	function get_nom(): string
	{
		return $this->nom;
	}

	/** Le type du groupement, temporel ou géographique
	 * 
	 * @return string
	 */
	function get_type(): string
	{
		return $this->type;
	}

	/** Récpère la clé a envoyer a l'API pour récuperrer le dit grroupement
	 * 
	 * @return string
	 */
	function get_cle(): string
	{
		return $this->cle;
	}
	#endregion getters

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
	#endregion Overides
}
