<?php

use Src\Config\ServerConf\DatabaseConnection;

$champ = "params";
$table = "Dashboards";
$query = "SELECT id, $champ FROM $table";
$rows = DatabaseConnection::fetchAll($query);
foreach ($rows as $row) {
	$id = $row['id'];
	$value = $row[$champ];

	// Vérifier si c'est un JSON valide
	json_decode($value);
	if (json_last_error() !== JSON_ERROR_NONE) {
		// Si ce n'est pas un JSON, on le transforme en JSON
		$jsonValue = json_encode([$value]);


		// Mise à jour dans la base de données
		$query = "UPDATE $table SET $champ = :jsonValue WHERE id = :id";
		DatabaseConnection::executeQuery($query, ['jsonValue' => $jsonValue, 'id' => $id]);
	}
}