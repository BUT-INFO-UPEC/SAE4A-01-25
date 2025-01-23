<?php

namespace Src\Model\Repository;

use Src\Model\Repository\AbstractRepository;

/**
 * classe pour les données qui sont juste des données
 */
abstract class AbstractRequestComponant extends AbstractRepository
{
    protected static array $cache = [];  // Cache statique propre à chaque classe fille
    protected static bool $cache_full = false;

    function get_object_by_id($id)
    {
        // Vérifie si l'objet est déjà dans le cache spécifique à cette classe
        if (isset(static::$cache[$id])) {  // Utilisation de static::$cache
            return static::$cache[$id]; // Retourne l'instance déjà initialisée
        }

        // Sinon, récupère l'objet depuis la base de données
        $objet = $this->select($id);

        // Stocke l'instance dans le cache de la classe
        static::$cache[$id] = $objet;  // Utilisation de static::$cache

        return $objet;
    }

    public function get_static_objects_list()
    {
        // Initialise les objets avec le cache spécifique à cette classe
        $objet = static::$cache;  // Utilisation de static::$cache

        // Si le cache complet n'est pas chargé
        if (!static::$cache_full) {
            if (!empty(static::$cache)) {
                // Construire les placeholders pour les IDs déjà en cache
                $whereQuery = "WHERE id NOT IN (";
                $i = 0;
                $values = [];
                foreach (static::$cache as $id => $value) {
                    $whereQuery .= ":id$i";
                    if ($i != sizeof(static::$cache) - 1) {
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
            static::$cache_full = true;  // Utilisation de static::$cache_full
        }
        return $objet;
    }
}
