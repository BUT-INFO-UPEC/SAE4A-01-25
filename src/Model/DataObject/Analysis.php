<?php

namespace Src\Model\DataObject;

use Src\Model\DataObject\AbstractDataObject;
use Src\Model\Repository\AggregationRepository;
use Src\Model\Repository\AttributRepository;
use Src\Model\Repository\GrouppingRepository;
use Src\Model\Repository\RepresentationRepository;

class Analysis extends AbstractDataObject
{
	#region Attributes
	// =======================
	//        ATTRIBUTES
	// =======================

	private ?int $id;
	private Attribut $attribut;
	private Aggregation $aggregation;
	private Groupping $groupping;
	private Representation $representation;
	#endregion Attributes
	public function __construct(?int $id, Attribut $attribut, Aggregation $aggregation, Groupping $groupping, Representation $repr_type)
	{
		$this->id = $id;
		$this->attribut = $attribut;
		$this->aggregation = $aggregation;
		$this->groupping = $groupping;
		$this->representation = $repr_type;
	}
	#region Getters
	// =======================
	//      GETTERS
	// =======================

	public function getId(): ?int {
		return $this->id;
	}
	public function getAttribut(): Attribut
	{
		return $this->attribut;
	}
	public function getAggregation(): Aggregation
	{
		return $this->aggregation;
	}
	public function getGroupping(): Groupping
	{
		return $this->groupping;
	}
	public function getRepresentation(): Representation
	{
		return $this->representation;
	}

	#endregion Getters

	#region Setters
	// =======================
	//      SETTERS
	// =======================

	public function setId(int $id): void{
		$this->id = $id;
	}

	public function setAttribut(Attribut $obj): void
	{
		$this->id = null;
		$this->attribut = $obj;
	}
	public function setAggregation(Aggregation $obj): void
	{
		$this->id = null;
		$this->aggregation = $obj;
	}
	public function setGroupping(Groupping $obj): void
	{
		$this->id = null;
		$this->groupping = $obj;
	}
	public function setRepresentation(Representation $obj): void
	{
		$this->id = null;
		$this->representation = $obj;
	}

	#endregion Setters
	public function formatTableau(): array
	{
		return [
			":id" => $this->id,
			"repr_type" => $this->representation->get_id(),
			"attribut" => $this->attribut->get_id(),
			"aggregation" => $this->aggregation->get_id(),
			"groupping" => $this->groupping->get_id()
		];
	}

	public function __toString(): string
	{
		return "new Analysis(" . ($this->id ?? 'null') . ", " . $this->attribut . ", " . $this->aggregation . ", " . $this->groupping . ", " . $this->representation . ")";
	}
}
