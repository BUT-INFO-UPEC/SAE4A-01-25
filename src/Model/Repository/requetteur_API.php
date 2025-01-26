<?php

namespace Src\Model\Repository;

use Src\Model\DataObject\Requette_API;

class Requetteur_API
{
	public static function fetchAll(
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
		$requette = new Requette_API(
			$select,
			$where,
			$group_by,
			$order_by,
			$limit,
			$offset,
			$refine_name,
			$refine_value,
			$exclude_name,
			$exclude_value,
			$time_zone
		);


		$url = $requette->formatQuery();
		// echo htmlspecialchars($url) . "<br>";

		$response = file_get_contents($url);
		if ($response === false) {
			throw new \Exception("Erreur lors de la récupération des données depuis l'API : <br/> $url.");
		}

		return json_decode($response, true);
	}
}
