<?php

namespace Src\Model\Repository;

use Src\Config\Utils\LogInstance;
use Src\Config\Utils\SessionManagement;
use Src\Model\DataObject\AbstractDataObject;
use Src\Model\Repository\AbstractRepository;

/**
 * Classe mettant en place le design patern singleton
 */
abstract class AbstractRequestComponant extends AbstractRepository
{
	#region Attributs
	// =======================
	//        ATTRIBUTES
	// =======================

	// Ce cache est partagé par toutes les classes filles pour éviter les redondance d'instances
	protected static $sharedCache = [];
	#endregion Attributs

	#region Publiques
	// =======================
	//    PUBLIC METHODS
	// =======================

	/** Vérifie si l'objet est dans le cache, si oui, le retourne, sinon l'instancie dans le cache avant
	 * 
	 * @param int $id
	 * 
	 * @return AbstractDataObject
	 */
	public function get_object_by_id(int $id): AbstractDataObject
	{
		// Vérifie si l'objet est déjà dans le cache spécifique à cette classe
		if ($this->getCache($id) != null) {  // Utilisation de static::$cache
			SessionManagement::get_curent_log_instance()->new_log("Récupération d'un objet dans le cache (économie d'une requette SQL) repo du type d'objet : " . get_called_class(), LogInstance::BLUE);
			return $this->getCache($id); // Retourne l'instance déjà initialisée
		}

		// Sinon, récupère l'objet depuis la base de données
		$objet = $this->select($id);

		// Stocke l'instance dans le cache de la classe
		$this->setCache($id, $objet);  // Utilisation de static::$cache

		return $objet;
	}

	/** Retourne la liste entière des objets de ce tpe en instanciant ceux manquant dans le cache
	 * 
	 * @return array
	 */
	public function get_static_objects_list(): array
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
		SessionManagement::get_curent_log_instance()->new_log("Taille mémoire du cache : " . strval($this->get_cache_size()));
		return $objet;
	}
	#endregion Publiques

	#region Protected
	// =======================
	//    PUBLIC PROTECTED
	// =======================

	/** Récupère l'instance associée a la clée dans le cache si il existe
	 * 
	 * @param string $key
	 * 
	 * @return AbstractDataObject|null
	 */
	protected function getCache(string $key): ?AbstractDataObject
	{
		$className = get_called_class();  // Récupère le nom de la classe fille actuelle
		if (!isset(self::$sharedCache[$className])) {
			self::$sharedCache[$className] = [];  // Initialiser le cache pour cette classe fille
		}
		return self::$sharedCache[$className][$key] ?? null;
	}

	/** Associe une instance a une clé dans le cache commun
	 * 
	 * @param string $key
	 * @param AbstractDataObject|bool $value l'instance a associer ou un booléen si la clée est "full"
	 * 
	 * @return void
	 */
	protected function setCache(string $key, AbstractDataObject|bool $value): void
	{
		$className = get_called_class();
		if (!isset(self::$sharedCache[$className])) {
			self::$sharedCache[$className] = [];
		}
		self::$sharedCache[$className][$key] = $value;
	}

	/** Récupère l'intégralité du cache pour la classe l'appelant
	 * 
	 * @return array
	 */
	protected function getCacheFull(): array
	{
		$className = get_called_class();  // Récupère le nom de la classe fille actuelle
		if (!isset(self::$sharedCache[$className])) {
			self::$sharedCache[$className] = [];  // Initialiser le cache pour cette classe fille
		}
		return self::$sharedCache[$className] ?? null;
	}
	#endregion Publiques

	private function get_cache_size(): int
	{
		return strlen(serialize(self::$sharedCache));
	}
}
