<?php
namespace Src\Model\Repository;

use PDO;
use Src\Model\DataObject\AbstractDataObject;
/**
 * classe mêre de toutes les données statiques du site pour eviter la redondance.
 */
abstract class AbstractRepository
{
  // =======================
  //    CRUD METHODS
  // =======================
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
    $tableau = $object->formatTableau();

    // Construire les différentes valeurs a mettre a jour
    $valeurs = "";
    foreach ($nomsColones as $colone) {
      $valeurs .= "$colone,";
    }
    $valeurs = substr($valeurs, 0,  -1); // retirer la virgule finale

    $cles = "";
    foreach ($tableau as $key => $value) {
      $cles .= ":$key,";
    }
    $cles = substr($cles, 0, -1); // retirer la virgule finale

    $query = "INSERT INTO $nomTable ($valeurs) VALUES ($cles);";
    $pdoStatement = DatabaseConnection::getPdo()->prepare($query);
    $pdoStatement->execute($tableau); // on donne les valeurs et on exécute la requête
  }

  /**
   * Selectionne un objet de la BDD selon un critère de clé primaire et le renvoie construit
   * 
   * @param string $valeurClePrimaire
   * 
   * @return AbstractDataObject|null
   */
  public function select(string $valeurClePrimaire): ?AbstractDataObject
  {
    $nomTable = $this->getTableName();
    $nomClePrimaire = $this->getNomClePrimaire();

    $sql = "SELECT * from $nomTable WHERE $nomClePrimaire = :clePrimaire ";
    $pdoStatement = DatabaseConnection::getPdo()->prepare($sql); // préparation de la requête
    $values = array( // préparation des valeurs
      "clePrimaire" => $valeurClePrimaire,
    );
    $pdoStatement->execute($values); // exécution de la requête

    // On récupère les résultats
    $objet = $pdoStatement->fetch(PDO::FETCH_ASSOC);
    if (!($objet)) return null;
    return $this->arrayConstructor($objet);
  }

  /**
   * Selectionne tout les objets correspondants de la BDD et les construits pour en renvoyer le tableau
   * 
   * @return AbstractDataObject[]
   */
  public function selectAll(): array
  {
    $objets = array();
    $nomTable = $this->getTableName();

    $pdoStatement = DatabaseConnection::getPdo()->query("SELECT * FROM $nomTable"); // récupéraiton des objets de la BDD

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
    $pdoStatement = DatabaseConnection::getPdo()->prepare($query);
    $tableau = $object->formatTableau();
    $tableau[":OLD" . $nomClePrimaire . "Tag"] = $ancienneClePrimaire;
    $pdoStatement->execute($tableau); // on donne les valeurs et on exécute la requête
  }

  /**
   * détruit un objet de la BDD selon un critère de clé primaire
   * 
   * @param string $valeurClePrimaire
   * 
   * @return void
   */
  public function delete(string $valeurClePrimaire): void
  {
    $nomTable = $this->getTableName();
    $nomClePrimaire = $this->getNomClePrimaire();

    $sql = "DELETE from $nomTable WHERE $nomClePrimaire = :clePrimaire ";
    $pdoStatement = DatabaseConnection::getPdo()->prepare($sql); // préparation de la requête
    $values = array( // préparation des valeurs
      "clePrimaire" => $valeurClePrimaire,
    );
    $pdoStatement->execute($values); // exécution de la requête
  }
  #endregion CRUD

  // =======================
  //    ABSTRACT METHODS
  // =======================
  #region abstraites
  /**
   * Définie le nom de la table de la BDD correspondant au type d'objet
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
