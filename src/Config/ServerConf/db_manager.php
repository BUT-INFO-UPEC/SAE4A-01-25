<?php

namespace Src\Config\ServerConf;

use ErrorException;
use Exception;
use PDOException;
use Src\Config\Utils\MsgRepository;

/**
 * Description de la classe
 */
class db_manager
{

	// =======================
	//        ATTRIBUTES
	// =======================
	#region Attributs
	static $DIR = __DIR__ . '/../../../database/Fixtures'; // Remplace avec le chemin du dossier que tu veux parcourir
	#endregion Attributs

	// =======================
	//      CONSTRUCTOR
	// =======================
	public function __construct()
	{
		// Constructeur
	}

	// =======================
	//      GETTERS
	// =======================
	#region Getters
	// Ajouter vos getters ici
	#endregion Getters

	// =======================
	//      SETTERS
	// =======================
	#region Setters
	// Ajouter vos setters ici
	#endregion Setters

	// =======================
	//    PUBLIC METHODS
	// =======================
	#region Publiques
	// Ajouter vos méthodes publiques ici
	#endregion Publiques

	// =======================
	//    PRIVATE METHODS
	// =======================
	#region Privees
	private static function getDoneFixtures()
	{
		try {
			$query = "SELECT name, num FROM FixturesHistory";
			$listDoneFixtures = DatabaseConnection::fetchAll($query);
		} catch (PDOException $e) {
			if (strpos($e->getMessage(), 'SQLSTATE[HY000]') !== false) {
				// La table n'existe pas, aucune fixture n'a encore été appliquée (la première Fixture crée la table)
				return [];
			} else {
				throw $e;
			}
		}
		// Formater la liste des fixtures pour faciliter la gestion
		$formatedDoneFixtures = [];
		foreach ($listDoneFixtures as $fixture) {
			// Mettre le nom de la fixture comme clé et l'indexer à partir de 0
			$formatedDoneFixtures[$fixture['name']] = $fixture["num"];
		}
		return $formatedDoneFixtures;
	}

	private static function getFixturesScripts()
	{
		if (is_dir(self::$DIR)) {
			$result = [];

			// Ouvrir le dossier parent
			$directories = scandir(self::$DIR);

			// Filtrer les éléments "." et ".."
			$directories = array_diff($directories, ['.', '..']);

			foreach ($directories as $dir) {
				$path = self::$DIR . DIRECTORY_SEPARATOR . $dir;

				// Vérifier si c'est un sous-dossier
				if (is_dir($path)) {
					// Initialiser un tableau pour ce sous-dossier
					$result[$dir] = [];

					// Récupérer les fichiers dans le sous-dossier
					$files = scandir($path);
					$files = array_diff($files, ['.', '..']); // Filtrer "." et ".."

					// Ajouter les fichiers dans le tableau du sous-dossier
					foreach ($files as $file) {
						$result[$dir][] = $file;
					}
				}
			}

			return $result;
		} else {
			throw new ErrorException("Le dossier spécifié n'existe pas." . self::$DIR);
		}
	}
	private static function updateDoneFixtures(string $branch, int $newDoneCount)
	{
		if (ServerParameters::$typeSgbd == "mysql") {
				// Préparer la requête d'insertion ou mise à jour
				$query = "INSERT INTO FixturesHistory (name, num) 
              VALUES (:branch, :newDoneCount)
              ON DUPLICATE KEY UPDATE num = :newDoneCount";
		} elseif (ServerParameters::$typeSgbd == "sqlite") {
				// Préparer la requête d'insertion ou mise à jour pour SQLite
				$query = "INSERT OR REPLACE INTO FixturesHistory (name, num) 
              VALUES (:branch, :newDoneCount)";
		}

		// Tableau des paramètres
		$params = [
			':branch' => $branch,
			':newDoneCount' => $newDoneCount
		];

		// Exécuter la requête via la méthode executeQuery
		try {
			DatabaseConnection::executeQuery($query, $params);
		} catch (PDOException $e) {
			throw new ErrorException('Erreur lors de la mise à jour des fixtures : ' . $e->getMessage());
		}
	}
	#endregion Privees

	// =======================
	//    STATIC METHODS
	// =======================
	#region Statiques
	/**
	 * @return array
	 */
	public static function update_fixtures(): array
	{
		try {
			$doneFixtures = self::getDoneFixtures();
			$allFixtures = self::getFixturesScripts();
		} catch (Exception $e) {
			MsgRepository::newError($e);
		}
		$appliedFixtures = [];

		foreach ($allFixtures as $branch => $fixtures) {
			$numberOfFixturesForBranch = count($fixtures);

			// Récupérer l'index de la première fixture à appliquer
			$startIndex = isset($doneFixtures[$branch]) ? $doneFixtures[$branch] : 0;

			for ($i = $startIndex; $i < $numberOfFixturesForBranch; $i++) {
				$filename = $fixtures[$i];
				require self::$DIR . DIRECTORY_SEPARATOR . $branch . DIRECTORY_SEPARATOR . $filename;
				$appliedFixtures[] = $filename;
			}

			// Mise à jour de la table des fixtures dans la BDD (après application des nouvelles fixtures)
			self::updateDoneFixtures($branch, $numberOfFixturesForBranch);
		}

		return $appliedFixtures;
	}

	#endregion Statiques

	// =======================
	//    OVERIDES
	// =======================
	#region Overides
	// Ajouter vos méthodes overrides ici
	#endregion Overides

}
