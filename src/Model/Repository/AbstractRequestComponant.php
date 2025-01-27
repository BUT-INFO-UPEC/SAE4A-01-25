<?php

namespace Src\Model\Repository;

use Src\Model\DataObject\AbstractDataObject;
use Src\Model\Repository\AbstractRepository;

/**
 * classe pour les données qui sont juste des données
 */
abstract class AbstractRequestComponant extends AbstractRepository
{

	// Ce cache est partagé par toutes les classes filles
	protected static $sharedCache = [];

	// Méthode pour obtenir ou manipuler le cache
	protected function getCache(string $key)
	{
		$className = get_called_class();  // Récupère le nom de la classe fille actuelle
		if (!isset(self::$sharedCache[$className])) {
			self::$sharedCache[$className] = [];  // Initialiser le cache pour cette classe fille
		}
		return self::$sharedCache[$className][$key] ?? null;
	}

	protected function setCache(string $key, $value)
	{
		$className = get_called_class();
		if (!isset(self::$sharedCache[$className])) {
			self::$sharedCache[$className] = [];
		}
		self::$sharedCache[$className][$key] = $value;
	}

	protected function getCacheFull()
	{
		$className = get_called_class();  // Récupère le nom de la classe fille actuelle
		if (!isset(self::$sharedCache[$className])) {
			self::$sharedCache[$className] = [];  // Initialiser le cache pour cette classe fille
		}
		return self::$sharedCache[$className] ?? null;
	}

	function get_object_by_id($id): AbstractDataObject
	{
		// Vérifie si l'objet est déjà dans le cache spécifique à cette classe
		if ($this->getCache($id) != null) {  // Utilisation de static::$cache
			return $this->getCache($id); // Retourne l'instance déjà initialisée
		}

		// Sinon, récupère l'objet depuis la base de données
		$objet = $this->select($id);

		// Stocke l'instance dans le cache de la classe
		$this->setCache($id, $objet);  // Utilisation de static::$cache

		return $objet;
	}

	public function get_static_objects_list()
	{
		// Initialise les objets avec le cache spécifique à cette classe
		$objet = $this->getCacheFull();  // Utilisation de static::$cache

		// Si le cache complet n'est pas chargé
		if (!$this->getCache("full")) {
			if (!empty($this->getCacheFull())) {
				// Construire les placeholders pour les IDs déjà en cache
				$whereQuery = "WHERE id NOT IN (";
				$i = 0;
				$values = [];
				foreach ($this->getCacheFull() as $id => $value) {
					$whereQuery .= ":id$i";
					if ($i != sizeof($this->getCacheFull()) - 1) {
						$whereQuery .= ", ";
					}
					$values["id$i"] = $id;
					$i++;
				}
				$whereQuery .= ");";
			} else {
				// Pas de condition si le cache est vide
				$whereQuery = "";
				$values = [];
			}
			// Récupérer les objets manquants depuis la base de données
			$newObjets = $this->selectAll($whereQuery, $values);

			// Fusionner les nouveaux objets avec ceux du cache
			$objet = array_merge($objet, $newObjets);

			// Marquer le cache comme complet
			$this->setCache("full", true);  // Utilisation de static::$cache_full
		}
		return $objet;
	}
}
