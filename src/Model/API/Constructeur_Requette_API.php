<?php

namespace Src\Model\API;

/**
 * QUE PERSONNE NE TOUCHE CETTE CLASS, ELLE FONCTIONNE TRES BIEN !!!
 */
class Constructeur_Requette_API
{
	private const BASE_URL = "https://public.opendatasoft.com/api/explore/v2.1/catalog/datasets/donnees-synop-essentielles-omm/records";
	private array $select;
	private ?array $where;
	private ?array $group_by;
	private string $order_by;
	private int $limit;
	private int $offset;
	private ?array $refine;
	private ?array $exclude;
	private string $lang;
	private string $timezone;

	public function __construct(
		array $select,
		array $where = null,
		array $group_by = null,
		string $order_by = '',
		int $limit = 100,
		int $offset = 0,
		array $refine = null,
		array $exclude = null,
		string $lang = "fr",
		string $timezone = "Europe/Paris"
	) {
		$this->select = $select;
		$this->where = $where;
		$this->group_by = $group_by;
		$this->order_by = $order_by;
		$this->limit = $limit;
		$this->offset = $offset;
		$this->refine = $refine;
		$this->exclude = $exclude;
		$this->lang = $lang;
		$this->timezone = $timezone;
	}

	public function getSelect(): ?string
	{
		return empty($this->select) ? null : "select=" . implode(",", $this->select);
	}

	public function getWhere(): ?string
	{
		return empty($this->where) ? null : "where=" . implode(" and ", $this->where);
	}

	public function getGroupBy(): ?string
	{
		return empty($this->group_by) ? null : "group_by=" . implode(",", $this->group_by);
	}

	public function getOrderBy(): ?string
	{
		return empty($this->order_by) ? null : "order_by=" . $this->order_by;
	}

	public function getLimit(): ?string
	{
		return $this->limit > 0 ? "limit=" . $this->limit : null;
	}

	public function getOffset(): ?string
	{
		return $this->offset > 0 ? "offset=" . $this->offset : null;
	}

	public function getRefine(): ?string
	{
		if (empty($this->refine)) {
			return null;
		}

		$refineParams = [];
		foreach ($this->refine as $key => $value) {
			$refineParams[] = "$key:$value";
		}
		return "refine=" . implode("&refine=", $refineParams);
	}

	public function getExclude(): ?string
	{
		if (empty($this->exclude)) {
			return null;
		}

		$excludeParams = [];
		foreach ($this->exclude as $key => $value) {
			$excludeParams[] = "$key:$value";
		}
		return "exclude=" . implode("&exclude=", $excludeParams);
	}

	public function getLang()
	{
		return $this->lang ? "lang=$this->lang" : null;
	}

	public function getTimeZone()
	{
		return $this->timezone ? "time_zone=$this->timezone" : null;
	}

	public function nextPage()
	{
		$this->offset += $this->limit;
	}

	/**
	 * Formate l'URL de la requête en utilisant http_build_query.
	 *
	 * @return string
	 */
	public function formatUrl(): string
	{
		$requetes = [
			$this->getSelect(),
			$this->getWhere(),
			$this->getGroupBy(),
			$this->getOrderBy(),
			$this->getOffset(),
			$this->getRefine(),
			$this->getExclude(),
			$this->getLang(),
			$this->getTimeZone(),
			$this->getLimit()
		];

		$params = [];
		foreach ($requetes as $param) {
			if ($param !== null) {
				$params[] = $param;
			}
		}
		// Utiliser http_build_query pour générer la chaîne de requête
		return self::BASE_URL . '?' . implode("&", $params);
	}
}
