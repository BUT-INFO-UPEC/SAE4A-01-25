<?php

require_once __DIR__ . '/../../Config/Conf.php';

/**
 * Gestion des connexions a la BDD (CRUD)
 */
class DatabaseConnection
{
  // =======================
  //        ATTRIBUTS
  // =======================
  #region Attributes
  private static $instance = null;
  private $pdo;
  #endregion Attributes

  // =======================
  //      CONSTRUCTEUR
  // =======================
  /**
   * Constructeur privé pour empêcher l'instanciation directe.
   */
  private function __construct()
  {
    $hostname = Conf::getHostname();
    $databaseName = Conf::getDatabase();
    $login = Conf::getLogin();
    $password = Conf::getPassword();

    // Connexion à la base de données
    // Le dernier argument sert à ce que toutes les chaines de caractères en entrée et sortie de MySql soit dans le codage UTF-8
    $this->pdo = new PDO("mysql:host=$hostname;dbname=$databaseName", $login, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

    //On active le mode d'affichage des erreurs, et le lancement d'exception en cas d'erreur
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  // =======================
  //    METHODES STATIQUES
  // =======================
  #region Static
  /**
   * Retourne l'instance PDO.
   *
   * @return PDO
   */
  static public function getPdo(): PDO
  {
    return static::getInstance()->pdo;
  }

  /**
   * Exécute une requête SQL avec des paramètres.
   *
   * @param string $query Requête SQL.
   * @param array $params Paramètres de la requête.
   * @return PDOStatement
   * @throws PDOException
   */
  static public function executeQuery(string $query, array $params = []): PDOStatement
  {
    try {
      $pdo = static::getPdo();
      $stmt = $pdo->prepare($query);
      $stmt->execute($params);
      return $stmt;
    } catch (PDOException $e) {
      throw $e;
    }
  }

  /**
   * GetInstance s'assure que le constructeur sera appelé une seule fois.
   * L'unique instance crée est stockée dans l'attribut $instance
   *
   * @return static
   */
  private static function getInstance()
  {
    // L'attribut statique $pdo s'obtient avec la syntaxe static::$pdo au lieu de $this->pdo pour un attribut non statique
    if (is_null(static::$instance))
      // Appel du constructeur
      static::$instance = new DatabaseConnection();
    return static::$instance;
  }
  #region Static
}
