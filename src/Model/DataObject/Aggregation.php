<?php

namespace Src\Model\DataObject;

use Src\Model\DataObject\AbstractDataObject;

/** Instance d'une aggregations proposées par l'application lors d'une analyse de données pour un composant d'un dashboard
 */
class Aggregation extends AbstractDataObject
{
	#region Attributs
	// =======================
	//        ATTRIBUTES
	// =======================

	private int $id;
	private string $nom;
	private string $cle;
	#endregion Attributs

	// =======================
	//      CONSTRUCTOR
	// =======================

	function __construct(int $id, string $nom, string $cle)
	{
		$this->id = $id;
		$this->nom = $nom;
		$this->cle = $cle;
	}

	#region Getters
	// =======================
	//      GETTERS
	// =======================

	/** L'identifiant de l'agregation dans la BDD
	 * 
	 * @return int
	 */
	function get_id(): int
	{
		return $this->id;
	}

	/** Le nom lié a l'agregation, permétant une compréhension de l'analyse proposée
	 * 
	 * @return string
	 */
	function get_nom(): string
	{
		return $this->nom;
	}

	/** La clé a reporter a l'API pour réaliser l'analyse d'agrégation
	 * 
	 * @return string
	 */
	function get_cle(): string
	{
		return $this->cle;
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
		return "new Aggregation(" . ($this->id ?? 'null') . ", '" . $this->nom . "', '" . $this->cle . "')";
	}
	#endregion Overides
}
