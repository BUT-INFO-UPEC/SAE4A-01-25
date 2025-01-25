<?php

namespace Src\Model\DataObject;

class Requette_API
{
	private array $select = [];
	private array $where = [];
	private array $group_by = [];
	private array $order_by = [];
	private ?int $limit = null;
	private ?int $offset = null;
	private ?string $refine_name = null;
	private $refine_value = null;
	private ?string $exclude_name = null;
	private $exclude_value = null;
	private ?string $time_zone = null;

	public function __construct(
		array $select = [],
		array $where = [],
		array $group_by = [],
		array $order_by = [],
		?int $limit = null,
		?int $offset = null,
		?string $refine_name = null,
		$refine_value = null,
		?string $exclude_name = null,
		$exclude_value = null,
		?string $time_zone = null
	) {
		$this->select = $select;
		$this->where = $where;
		$this->group_by = $group_by;
		$this->order_by = $order_by;
		$this->limit = $limit;
		$this->offset = $offset;
		$this->refine_name = $refine_name;
		$this->refine_value = $refine_value;
		$this->exclude_name = $exclude_name;
		$this->exclude_value = $exclude_value;
		$this->time_zone = $time_zone;
	}

	public function formatQuery(): string
	{
		$query = array_filter([
			$this->getSelect(),
			$this->getWhere(),
			$this->getGroupBy(),
			$this->getOrderBy(),
			$this->getLimit(),
			$this->getOffset(),
			$this->getRefineName(),
			$this->getRefineValue(),
			$this->getExcludeName(),
			$this->getExcludeValue(),
			$this->getTimeZone(),
		], fn($item) => $item !== null && $item !== '');
		$url = "https://public.opendatasoft.com/api/explore/v2.1/catalog/datasets/donnees-synop-essentielles-omm/records";
		return $url . "?" . implode("&", $query);
	}

	public function getSelect(): ?string
	{
		return $this->select ? "select=" . urlencode(implode(',', $this->select)) : null;
	}
	public function getWhere(): ?string
	{
		return $this->where ? "where=" . urlencode(implode(',', $this->where)) : null;
	}
	public function getGroupBy(): ?string
	{
		return $this->group_by ? "group_by=" . urlencode(implode(',', $this->group_by)) : null;
	}
	public function getOrderBy(): ?string
	{
		return $this->order_by ? "order_by=" . urlencode(implode(',', $this->order_by)) : null;
	}
	public function getLimit(): ?string
	{
		return $this->limit ? "limit=" . urlencode((string)$this->limit) : null;
	}
	public function getOffset(): ?string
	{
		return $this->offset ? "offset=" . urlencode((string)$this->offset) : null;
	}
	public function getRefineName(): ?string
	{
		return $this->refine_name ? "refine_name=" . urlencode($this->refine_name) : null;
	}
	public function getRefineValue(): ?string
	{
		return $this->refine_value ? "refine_value=" . urlencode((string)$this->refine_value) : null;
	}
	public function getExcludeName(): ?string
	{
		return $this->exclude_name ? "exclude_name=" . urlencode($this->exclude_name) : null;
	}
	public function getExcludeValue(): ?string
	{
		return $this->exclude_value ? "exclude_value=" . urlencode((string)$this->exclude_value) : null;
	}
	public function getTimeZone(): ?string
	{
		return $this->time_zone ? "time_zone=" . urlencode($this->time_zone) : null;
	}
}
