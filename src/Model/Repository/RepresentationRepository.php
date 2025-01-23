<?php

namespace Src\Model\Repository;

use Src\Model\Repository\AbstractRepository;
use Src\Model\DataObject\Representation;

class RepresentationRepository extends AbstractRepository
{
	public function get_representation_by_id($id): Representation
	{
		// créer une liste statique (genre PDO) et vérifier sil'attribut est déja initialisé, auquel cas donner l'instance, sinon, instancier
		return $this->select($id);
	}

	public  function arrayConstructor(array $objetFormatTableau): Representation {
		return new Representation($objetFormatTableau["id"], $objetFormatTableau["name"], $objetFormatTableau["poss_groupping"], $objetFormatTableau["visu_fichier"]);
	}
	
	public  function getNomClePrimaire(): string {
		return "id";
	}
	
	public  function getNomsColonnes(): array {
		return ["id", "name", "poss_groupping", "visu_fichier"];
	}
	
	public  function getTableName(): string {
		return "Representations";
	}
}
