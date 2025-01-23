<?php

namespace Src\Model\Repository;

class RequettesBDD {
	public static function getRepresentations($id) {
		$querry = "SELECT visu_fichier FROM Representations WHERE id = :reprId";
		$values = ["reprId" => $id];
		$pdoStatement = DatabaseConnection::executeQuery($querry, $values);
		return $pdoStatement->fetch()["visu_fichier"];
	}
}