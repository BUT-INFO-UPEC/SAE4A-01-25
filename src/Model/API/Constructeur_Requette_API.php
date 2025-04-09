<?php

namespace Src\Model\API;

/** Construit la requette a l'API a partir des paramètres donnés
 */
class Constructeur_Requette_API
{
	#region Attributs
	// =======================
	//        ATTRIBUTES
	// =======================

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
	#endregion Attributs

	// =======================
	//      CONSTRUCTOR
	// =======================

	public function __construct(
		array $select,
		array $where = [],
		array $group_by = [],
		string $order_by = '',
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
		$this->order_by = $order_by;
		$this->limit = $limit;
		$this->offset = $offset;
		$this->refine = $refine;
		$this->exclude = $exclude;
		$this->lang = $lang;
		$this->timezone = $timezone;
	}

	#region Getters
	// =======================
	//      GETTERS
	// =======================

	/** Formate le paramètre select de la requette (qu'est-ce que la requette récupère comme données)
	 *
	 * @return string|null
	 */
	public function getSelect(): ?string
	{
		return empty($this->select) ? null : "select=" . urlencode(implode(",", $this->select));
	}

	/** Formate le paramètre where de la requette (comment la requette selectionne les données a retourner -lequels)
	 *
	 * @return string|null
	 */
	public function getWhere(): ?string
	{
		return empty($this->where) ? null : "where=" . urlencode(implode(" and ", $this->where));
	}

	/** Formate le paramètre groupby de la requette (groupe les données pour leur appliquer le critère d'agrégation)
	 *
	 * @return string|null
	 */
	public function getGroupBy(): ?string
	{
		return empty($this->group_by) ? null : "group_by=" . urlencode(implode(",", $this->group_by));
	}

	/** Formate le paramètre orderby de la requette (définie l'ordre de la liste de données retournée)
	 *
	 * @return string|null
	 */
	public function getOrderBy(): ?string
	{
		return empty($this->order_by) ? null : "order_by=" . urlencode($this->order_by);
	}

	/** Formate le paramètre limit de la requette (définie le nombre maximum de données par page)
	 *
	 * @return string|null
	 */
	public function getLimit(): ?string
	{
		return $this->limit > 0 ? "limit=" . urlencode($this->limit) : null;
	}

	/** Formate le paramètre offset de la requette (définie a partir de quel index de donnée la requette doit rnvoyer les données suivantes)
	 *
	 * @return string|null
	 */
	public function getOffset(): ?string
	{
		return $this->offset > 0 ? "offset=" . urlencode($this->offset) : null;
	}

	/** Désolé, aucune idée
	 * 
	 * @return string|null
	 */
	public function getRefine(): ?string
	{
		if (empty($this->refine)) {
			return null;
		}

		$refineParams = [];
		foreach ($this->refine as $key => $value) {
			$refineParams[] = "$key:$value";
		}
		return "refine=" . urlencode(implode("&refine=", $refineParams));
	}

	/** Désolé, aucune idée
	 *
	 * @return string|null
	 */
	public function getExclude(): ?string
	{
		if (empty($this->exclude)) {
			return null;
		}

		$excludeParams = [];
		foreach ($this->exclude as $key => $value) {
			$excludeParams[] = "$key:$value";
		}
		return "exclude=" . urlencode(implode("&exclude=", $excludeParams));
	}

	/** Formate le paramètre lang de la requette (dans quelle langue les données doivent etre renvoyées)
	 *
	 * @return string|null
	 */
	public function getLang()
	{
		return $this->lang ? "lang=" . urlencode($this->lang) : null;
	}

	/** Formate le paramètre time_zone de la requette (pour prendre en compte le décalage horaire)
	 *
	 * @return string|null
	 */
	public function getTimeZone(): ?string
	{
		return $this->timezone ? "time_zone=" . urlencode($this->timezone) : null;
	}
	#endregion Getters

	#region Publiques
	// =======================
	//    PUBLIC METHODS
	// =======================

	/** Récupère la prochaine page de la requette en décalant les données récupérées du nombre de données par page
	 *
	 * @return void
	 */
	public function nextPage(): void
	{
		$this->offset += $this->limit;
	}

	/** Formate l'URL de la requête en utilisant http_build_query.
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
	#endregion Publiques
}
