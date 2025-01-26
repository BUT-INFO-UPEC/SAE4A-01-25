<?php

namespace Src\Model\DataObject;

use Exception;

class Requette_API
{
    private const BASE_URL = "https://public.opendatasoft.com/api/explore/v2.1/catalog/datasets/donnees-synop-essentielles-omm/records";
    private const SELECT_LIMIT_1 = ['avg()', 'count', 'count distinct', 'envelope', 'max', 'median', 'min', 'percentile', 'sum'];

    private array $select;
    private array $where;
    private array $group_by;
    private string $order_by;  // Modifié en string
    private int $limit;
    private int $offset;
    private array $refine;
    private array $exclude;
    private string $lang;
    private string $timezone;

    private array $params = [];

    public function __construct(
        array $select = [],
        array $where = [],
        array $group_by = [],
        string $order_by = '',  // Modifié en string
        int $limit = 100,
        int $offset = 0,
        array $refine = [],
        array $exclude = [],
        string $lang = "fr",
        string $timezone = "Europe/Paris"
    ) {
        $this->select = $select;
        $this->where = $where;
        $this->group_by = $group_by;
        $this->order_by = $order_by;  // Assignation du paramètre string
        $this->limit = $limit;
        $this->offset = $offset;
        $this->refine = $refine;
        $this->exclude = $exclude;
        $this->lang = $lang;
        $this->timezone = $timezone;
    }

    /**
     * Retourne les éléments de $select sous forme de chaîne de caractères, préfixé par "select=" et séparés par des virgules.
     * 
     * @return string|null
     */
    public function getSelect(): ?string
    {
        // encoder url tout les éléments de la liste
        foreach ($this->select as $item) {
            $this->select[] = urlencode($item);
        }
        try {
            return "select=" . implode(",", $this->select);
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Retourne les éléments de $where sous forme de chaîne de caractères, préfixé par "where=" et séparés par " and ".
     * 
     * @return string|null
     */
    public function getWhere(): ?string
    {
        return !empty($this->where) ? "where=" . implode(' and ', $this->where) : null;
    }

    /**
     * Retourne les éléments de $group_by sous forme de chaîne de caractères, préfixé par "group_by=" et séparés par ", ".
     * 
     * @return string|null
     */
    public function getGroupBy(): ?string
    {
        return !empty($this->group_by) ? "group_by=" . implode(', ', $this->group_by) : null;
    }

    /**
     * Retourne l'élément de $limit sous forme de chaîne de caractères, préfixé par "limit=".
     * 
     * @return string|null
     */
    public function getLimit(): ?string
    {
        return !empty($this->limit) ? "limit=" . $this->limit : null;
    }

    /**
     * Retourne l'élément de $order_by sous forme de chaîne de caractères, préfixé par "order_by=".
     * 
     * @return string|null
     */
    public function getOrderBy(): ?string
    {
        return !empty($this->order_by) ? "order_by=" . $this->order_by : null;
    }

    /**
     * Retourne le premier élément de $refine sous forme de chaîne, préfixé par "refine=".
     * 
     * @return string|null
     */
    public function getRefine(): ?string
    {
        if (!empty($this->refine)) {
            $key = key($this->refine);
            $value = current($this->refine);
            return "refine=" . $key . ":" . $value;
        }
        return null;
    }

    /**
     * Retourne le premier élément de $exclude sous forme de chaîne, préfixé par "exclude=".
     * 
     * @return string|null
     */
    public function getExclude(): ?string
    {
        if (!empty($this->exclude)) {
            $key = key($this->exclude);
            $value = current($this->exclude);
            return "exclude=" . $key . ":" . $value;
        }
        return null;
    }

    /**
     * Formate l'URL de la requête en ajoutant les paramètres de la requête à la base de l'URL.
     * 
     * @return string
     */
    public function formatUrl(): string
    {
        $url = self::BASE_URL;
        $queryParams = [];

        // Ajouter les paramètres de la requête à l'URL en excluant les vides ou null
        $select = $this->getSelect();
        if ($select) {
            $queryParams[] = urlencode($select);
        }

        $where = $this->getWhere();
        if ($where) {
            $queryParams[] = urlencode($where);
        }

        $group_by = $this->getGroupBy();
        if ($group_by) {
            $queryParams[] = urlencode($group_by);
        }

        $order_by = $this->getOrderBy();
        if ($order_by) {
            $queryParams[] = urlencode($order_by);
        }

        $refine = $this->getRefine();
        if ($refine) {
            $queryParams[] = urlencode($refine);
        }

        $exclude = $this->getExclude();
        if ($exclude) {
            $queryParams[] = urlencode($exclude);
        }

        // Ajouter explicitement les paramètres limit et offset
        if ($this->limit > 0) {
            $queryParams[] = "limit=" . urlencode($this->limit);
        }
        if ($this->offset > 0) {
            $queryParams[] = "offset=" . urlencode($this->offset);
        }

        // Filtrer les paramètres vides ou null
        $queryParams = array_filter($queryParams, function ($value) {
            return !is_null($value) && $value !== '';
        });

        // Ajouter les paramètres non vides à l'URL
        if (!empty($queryParams)) {
            $url .= '?' . implode('&', $queryParams);
        }

        return $url;
    }
}
