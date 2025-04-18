<?php

namespace Src\Model\Repository;

use Src\Config\Utils\MsgRepository;
use Src\Config\ServerConf\DatabaseConnection;
use Src\Model\DataObject\AbstractDataObject;

/**
 * classe mêre de toutes les données statiques du site pour eviter la redondance.
 */
abstract class AbstractRepository
{
	#region CRUD
	// =======================
	//  Create Read Update Delete
	// =======================

	/**
	 * Selectionne un objet de la BDD selon un critère de clé primaire et le renvoie construit
	 *
	 * @param string $valeurClePrimaire
	 *
	 * @return AbstractDataObject|null
	 */
	public function select(string $valeurClePrimaire, $adiitionnalQuery="", $aditionnalValues=[]): ?AbstractDataObject
	{
		$nomTable = $this->getTableName();
		$nomClePrimaire = $this->getNomClePrimaire();

		$query = "SELECT * from $nomTable WHERE $nomClePrimaire = :clePrimaire " . $adiitionnalQuery;
		$values = [ // préparation des valeurs
			"clePrimaire" => $valeurClePrimaire,
		];
		$values = array_merge($values, $aditionnalValues);

		$objet = DatabaseConnection::fetchOne($query, $values);

		if (!($objet)) return null;
		return $this->arrayConstructor($objet);
	}

	/**
	 * Selectionne tout les objets correspondants de la BDD et les construits pour en renvoyer le tableau
	 *
	 * @return AbstractDataObject[]
	 */
	public function selectAll($adiitionnalQuery, $values): array
	{
		$objets = [];
		$nomTable = $this->getTableName();

		$query = "SELECT * FROM $nomTable $adiitionnalQuery;";

		$pdoStatement = DatabaseConnection::fetchAll($query, $values); // récupéraiton des objets de la BDD

		foreach ($pdoStatement as $objetFormatTableau) { // itération pour construction
			$objets[] = $this->arrayConstructor($objetFormatTableau);
		}

		return $objets;
	}

	/**
	 * Inscrit statiquement l'objet dans la BDD
	 *
	 * @param AbstractDataObject $object L'objet de la classe dynamique correspondante
	 *
	 * @return void
	 */
	public function create(AbstractDataObject $object, $values = []): mixed
	{
		$nomTable = $this->getTableName();
		$nomsColones = $this->getNomsColonnes();
		$values = array_merge($object->formatTableau(), $values); // bien mettre $values en deuxiemme pour écraser toute clé partagée par ses vapeurs au lieu de celle par défaut

		$valeurs = implode(", ", $nomsColones); // juste le nom des différentes collones

		$cles = implode(", ", array_keys($values)); // noms des clés des valeurs avec les ":"

		$clePrimaire = $this->getNomClePrimaire();

		$query = "INSERT INTO $nomTable ($valeurs) VALUES ($cles) RETURNING $clePrimaire;"; // enregistrer et récupérer la clé primaire

		$v = DatabaseConnection::fetchOne($query, $values);
		return $v[$clePrimaire];
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
		$nomClePrimaire = $this->getNomClePrimaire();

		$values = $object->formatTableau();
		$insert = "";
		foreach ($values as $key=>$value) {
			$insert .= substr($key, 1) . " = " . $key . ", ";
		}
		$insert = substr($insert, 0, -2);

		$query = "UPDATE $nomTable SET $insert WHERE $nomClePrimaire = :OLD" . $nomClePrimaire . "Tag;";
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
	// =======================
	//    ABSTRACTS
	// =======================

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
	protected abstract function arrayConstructor(array $objetFormatTableau): ?AbstractDataObject;

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
