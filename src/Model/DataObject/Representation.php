<?php

namespace Src\Model\DataObject;

use Src\Model\DataObject\AbstractDataObject;

class Representation extends AbstractDataObject
{
	#region Attributs
	// =======================
	//        ATTRIBUTES
	// =======================
	
	private int $id;
	private string $nom;
	private string $fichier_visu;
	#endregion Attributs

	// =======================
	//      CONSTRUCTOR
	// =======================

	function __construct($id, $nom, $grouppings, $fichier_visu)
	{
		$this->id = $id;
		$this->nom = $nom;
		$this->fichier_visu = $fichier_visu;
	}

	#region Getters
	// =======================
	//      GETTERS
	// =======================

	/** L'identifiant de la représentation dans la BDD
	 * 
	 * @return int
	 */
	function get_id(): int
	{
		return $this->id;
	}

	/** Le nom associé a la représentation
	 * 
	 * @return string
	 */
	function get_nom(): string
	{
		return $this->nom;
	}

	/** Récupère le nom du ficher de génération de la représentation spécifiée
	 * 
	 * @return string
	 */
	function get_visu_file(): string
	{
		return $this->fichier_visu;
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
	#endregion Overides
}
