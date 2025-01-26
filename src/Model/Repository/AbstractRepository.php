<?php

namespace Src\Model\Repository;

use PDO;
use Src\Model\DataObject\AbstractDataObject;

/**
 * classe mêre de toutes les données statiques du site pour eviter la redondance.
 */
abstract class AbstractRepository
{
	#region CRUD
	/**
	 * Inscrit statiquement l'objet dans la BDD
	 * 
	 * @param AbstractDataObject $object L'objet de la classe dynamique correspondante
	 * 
	 * @return void
	 */
	public function create(AbstractDataObject $object): void
	{
		$nomTable = $this->getTableName();
		$nomsColones = $this->getNomsColonnes();
		$values = $object->formatTableau();

		// Construire les différentes valeurs a mettre a jour
		// $valeurs = "";
		// foreach ($nomsColones as $colone) {
		// 	$valeurs .= "$colone,";
		// }
		// $valeurs = substr($valeurs, 0,  -1); // retirer la virgule finale
		$valeurs = implode(", ", $nomsColones);

		// $cles = "";
		// foreach ($values as $key => $value) {
		// 	$cles .= ":$key,";
		// }
		// $cles = substr($cles, 0, -1); // retirer la virgule finale
		$cles = implode(", ", array_keys($values));

		$query = "INSERT INTO $nomTable ($valeurs) VALUES ($cles);";
		DatabaseConnection::executeQuery($query, $values);
	}

	/**
	 * Selectionne un objet de la BDD_ selon un critère de clé primaire et le renvoie construit
	 * 
	 * @param string $valeurClePrimaire
	 * 
	 * @return AbstractDataObject|null
	 */
	public function select(string $valeurClePrimaire): ?AbstractDataObject
	{
		$nomTable = $this->getTableName();
		$nomClePrimaire = $this->getNomClePrimaire();

		$query = "SELECT * from $nomTable WHERE $nomClePrimaire = :clePrimaire ";
		$values = [ // préparation des valeurs
			"clePrimaire" => $valeurClePrimaire,
		];
		$pdoStatement = DatabaseConnection::executeQuery($query, $values);

		// On récupère les résultats
		$objet = $pdoStatement->fetch(PDO::FETCH_ASSOC);
		if (!($objet)) return null;
		return $this->arrayConstructor($objet);
	}

	/**
	 * Selectionne tout les objets correspondants de la BDD_ et les construits pour en renvoyer le tableau
	 * 
	 * @return AbstractDataObject[]
	 */
	public function selectAll($whereQuery, $values): array
	{
		$objets = [];
		$nomTable = $this->getTableName();

		$query = "SELECT * FROM $nomTable $whereQuery;";
		$pdoStatement = DatabaseConnection::executeQuery($query, $values); // récupéraiton des objets de la BDD

		foreach ($pdoStatement as $objetFormatTableau) { // itération pour construction
			$objets[] = $this->arrayConstructor($objetFormatTableau);
		}

		return $objets;
	}

	/**
	 * Mets a jour un objet dynamique correspondant dans la BDD
	 * 
	 * @param AbstractDataObject $object L'objet de la classe dynamique correspondante
	 * 
	 * @return void
	 */
	public function update(AbstractDataObject $object, string $ancienneClePrimaire): void
	{
		$nomTable = $this->getTableName();
		$nomsColones = $this->getNomsColonnes();
		$nomClePrimaire = $this->getNomClePrimaire();

		// Construire les différentes valeurs a mettre a jour
		$valeurs = "";
		foreach ($nomsColones as $colone) {
			$valeurs .= "$colone = :" . $colone . "Tag,";
		}
		$valeurs = substr($valeurs, 0,  -1); // retirer la virgule finale

		$query = "UPDATE $nomTable SET $valeurs WHERE $nomClePrimaire = :OLD" . $nomClePrimaire . "Tag;";
		$values = $object->formatTableau();
		$values[":OLD" . $nomClePrimaire . "Tag"] = $ancienneClePrimaire;
		DatabaseConnection::executeQuery($query, $values);
	}

	/**
	 * détruit un objet de la BDD_ selon un critère de clé primaire
	 * 
	 * @param string $valeurClePrimaire
	 * 
	 * @return void
	 */
	public function delete(string $valeurClePrimaire): void
	{
		$nomTable = $this->getTableName();
		$nomClePrimaire = $this->getNomClePrimaire();

		$query = "DELETE from $nomTable WHERE $nomClePrimaire = :clePrimaire ";
		$values = [ // préparation des valeurs
			"clePrimaire" => $valeurClePrimaire,
		];
		// $pdoStatement = DatabaseConnection::getPdo()->prepare($sql); // préparation de la requête
		// $pdoStatement->execute($values); // exécution de la requête
		DatabaseConnection::executeQuery($query, $values);
	}
	#endregion CRUD

	#region abstraites
	/**
	 * Définie le nom de la table de la BDD_ correspondant au type d'objet
	 * 
	 * @return string
	 */
	protected abstract function getTableName(): string;

	/**
	 * Construit l'instance dynamique a partir des données statiques
	 * 
	 * @param array $objetFormatTableau
	 * 
	 * @return AbstractDataObject
	 */
	protected abstract function arrayConstructor(array $objetFormatTableau): AbstractDataObject;

	/**
	 * Définie le nom de la clé primaire du type d'objet dans la BDD
	 * 
	 * @return string
	 */
	protected abstract function getNomClePrimaire(): string;

	/**
	 * Définie les différentes données présentes dans la BDD
	 * 
	 * @return array
	 */
	protected abstract function getNomsColonnes(): array;
	#endregion abstraites
}
