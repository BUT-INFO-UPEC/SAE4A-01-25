<?php
// Chemin vers la base de données
$db_path = 'database/France.db'; // Ajustez le chemin de la base de données
$db_france = new PDO('sqlite:' . $db_path);
$db_france->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fonction pour supprimer la base de données
function supprDatabase($db)
{
    // Supprimer le fichier de la base de données
    if (file_exists($db)) {
        unlink($db);
        echo "Base de données supprimée avec succès.<br>";
    } else {
        echo "Le fichier de la base de données n'existe pas.<br>";
    }
}

// Fonction pour créer les tables
function createTables($db)
{
    try {
        // Connexion à la base de données SQLite
        $conn = new PDO("sqlite:" . $db);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Création de la table "region"
        $create_region_table = "
        CREATE TABLE IF NOT EXISTS regions (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL
        );
        ";
        $conn->exec($create_region_table);
        echo "Table 'regions' créée avec succès.<br>";

        // Création de la table "dept"
        $create_dept_table = "
        CREATE TABLE IF NOT EXISTS depts (
            id INTEGER,
            name TEXT NOT NULL,
            reg_id INTEGER,
            FOREIGN KEY (reg_id) REFERENCES regions(id)
        );
        ";
        $conn->exec($create_dept_table);
        echo "Table 'depts' créée avec succès.<br>";

        // Création de la table "dept"
        $create_dept_table = "
        CREATE TABLE IF NOT EXISTS epcis (
            id INTEGER,
            name TEXT NOT NULL,
            dept_id INTEGER,
            FOREIGN KEY (dept_id) REFERENCES depts(id)
        );
        ";
        $conn->exec($create_dept_table);
        echo "Table 'epcis' créée avec succès.<br>";

        // Création de la table "dept"
        $create_dept_table = "
        CREATE TABLE IF NOT EXISTS villes (
            id INTEGER,
            name TEXT NOT NULL,
            epci_id INTEGER,
            FOREIGN KEY (epci_id) REFERENCES epcis(id)
        );
        ";
        $conn->exec($create_dept_table);
        echo "Table 'villes' créée avec succès.<br>";

        // Création de la table "dept"
        $create_dept_table = "
        CREATE TABLE IF NOT EXISTS stations (
            id INTEGER,
            name TEXT NOT NULL,
            latitude INTEGER,
            longitude INTEGER,
            ville_id INTEGER,
            FOREIGN KEY (ville_id) REFERENCES villes(id)
        );
        ";
        $conn->exec($create_dept_table);
        echo "Table 'stations' créée avec succès.<br>";

    } catch (PDOException $e) {
        echo "Erreur lors de la création des tables : " . $e->getMessage() . "<br>";
    } finally {
        $conn = null; // Déconnexion
    }
}

// Fonction pour insérer des données
function insertData($db){
    shell_exec(command: 'py rempissage_stations.py');
}