<?php

namespace Src\Model\Repository;

use Src\Model\Repository\AbstractRequestComponant;
use Src\Model\DataObject\Representation;

class RepresentationRepository extends AbstractRequestComponant
{
	public function get_representation_by_id($id): Representation
	{
		return $this->get_object_by_id($id);
	}

	public function get_representations(): array
	{
		return $this->get_static_objects_list();
	}

	public  function arrayConstructor(array $objetFormatTableau): Representation
	{
		return new Representation($objetFormatTableau["id"], $objetFormatTableau["name"], $objetFormatTableau["poss_groupping"], $objetFormatTableau["visu_fichier"]);
	}

	public  function getNomClePrimaire(): string
	{
		return "id";
	}

	public  function getNomsColonnes(): array
	{
		return ["id", "name", "poss_groupping", "visu_fichier"];
	}

	public  function getTableName(): string
	{
		return "Representations";
	}
}
