<?php
// Charger le fichier JSON contenant la définition de la table
$jsonFile = 'structure.json';
$jsonData = file_get_contents($jsonFile);

if ($jsonData === false) {
  die("Impossible de lire le fichier JSON.\n");
}

// Décoder le JSON
$tableDefinition = json_decode($jsonData, true);

if (json_last_error() !== JSON_ERROR_NONE) {
  die("Erreur de décodage JSON : " . json_last_error_msg() . "\n");
}

// Valider la structure JSON
if (!isset($tableDefinition['table_name'], $tableDefinition['columns'])) {
  die("La structure JSON est invalide.\n");
}

// Connexion à la base SQLite
$dbFile = 'database.db';
try {
  $pdo = new PDO("sqlite:" . $dbFile);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Construire la commande SQL de création de table
  $tableName = $tableDefinition['table_name'];
  $columns = $tableDefinition['columns'];
  $columnDefinitions = [];

  foreach ($columns as $column) {
    if (!isset($column['name'], $column['type'])) {
      die("Définition de colonne invalide.\n");
    }
    $definition = $column['name'] . " " . $column['type'];
    if (isset($column['constraints'])) {
      $definition .= " " . $column['constraints'];
    }
    $columnDefinitions[] = $definition;
  }

  $createTableSQL = "CREATE TABLE IF NOT EXISTS $tableName (" . implode(", ", $columnDefinitions) . ");";
  $pdo->exec($createTableSQL);
  echo "Table '$tableName' créée avec succès dans la base de données.\n";

  // Gestion des triggers
  if (isset($tableDefinition['triggers']) && is_array($tableDefinition['triggers'])) {
    foreach ($tableDefinition['triggers'] as $trigger) {
      if (!isset($trigger['name'], $trigger['timing'], $trigger['event'], $trigger['statement'])) {
        die("Définition de trigger invalide.\n");
      }
      $triggerName = $trigger['name'];
      $timing = $trigger['timing'];
      $event = $trigger['event'];
      $statement = $trigger['statement'];

      $createTriggerSQL = "CREATE TRIGGER IF NOT EXISTS $triggerName
                                 $timing $event ON $tableName
                                 FOR EACH ROW
                                 $statement";
      $pdo->exec($createTriggerSQL);
      echo "Trigger '$triggerName' créé avec succès.\n";
    }
  }
} catch (PDOException $e) {
  die("Erreur lors de la création de la base de données : " . $e->getMessage() . "\n");
}
