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
            FOREIGN KEY (reg_id) REFERENCES region(id)
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

// // Fonction pour insérer des données
// function insertData($db)
// {
//     try {
//         // Connexion à la base de données SQLite
//         $conn = new PDO("sqlite:" . $db);
//         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//         // Insertion de données dans la table "region"
//         $insert_region = "
//         INSERT INTO region (name)
//         VALUES
//         ('Auvergne-Rhône-Alpes'),
//         ('Bourgogne-Franche-Comté'),
//         ('Bretagne'),
//         ('Centre-Val de Loire'),
//         ('Corse'),
//         ('Grand Est'),
//         ('Hauts-de-France'),
//         ('Normandie'),
//         ('Nouvelle-Aquitaine'),
//         ('Occitanie'),
//         ('Pays de la Loire'),
//         ('Provence-Alpes-Côte d''Azur'),
//         ('Guadeloupe'),
//         ('Martinique'),
//         ('Guyane'),
//         ('La Réunion'),
//         ('Mayotte');
//         ";
//         $conn->exec($insert_region);
//         echo "Données insérées dans la table 'region' avec succès.<br>";

//         // Insertion de données dans la table "dept"
//         $insert_dept = "
//         INSERT INTO dept (id, name, region_id)
//         VALUES
//             (1, 'Ain', 1),
//             (2, 'Aisne', 9),
//             (3, 'Allier', 1),
//             (4, 'Alpes-de-Haute-Provence', 16),
//             (5, 'Hautes-Alpes', 16),
//             (6, 'Alpes-Maritimes', 16),
//             (7, 'Ardèche', 1),
//             (8, 'Ardennes', 6),
//             (9, 'Ariège', 14),
//             (10, 'Aube', 6),
//             (11, 'Aude', 14),
//             (12, 'Aveyron', 14),
//             (13, 'Bouches-du-Rhône', 16),
//             (14, 'Calvados', 12),
//             (15, 'Cantal', 1),
//             (16, 'Charente', 14),
//             (17, 'Charente-Maritime', 14),
//             (18, 'Cher', 4),
//             (19, 'Corrèze', 14),
//             (20, 'Corse-du-Sud', 5),
//             (21, 'Côte-d''Or', 2),
//             (22, 'Côtes-d''Armor', 3),
//             (23, 'Creuse', 14),
//             (24, 'Dordogne', 14),
//             (25, 'Doubs', 2),
//             (26, 'Drôme', 1),
//             (27, 'Eure', 12),
//             (28, 'Eure-et-Loir', 4),
//             (29, 'Finistère', 3),
//             (30, 'Gard', 14),
//             (31, 'Haute-Garonne', 14),
//             (32, 'Gers', 14),
//             (33, 'Gironde', 14),
//             (34, 'Hérault', 14),
//             (35, 'Ille-et-Vilaine', 3),
//             (36, 'Indre', 4),
//             (37, 'Indre-et-Loire', 4),
//             (38, 'Isère', 1),
//             (39, 'Jura', 2),
//             (40, 'Landes', 14),
//             (41, 'Loir-et-Cher', 4),
//             (42, 'Loire', 1),
//             (43, 'Haute-Loire', 1),
//             (44, 'Loire-Atlantique', 15),
//             (45, 'Loiret', 4),
//             (46, 'Lot', 14),
//             (47, 'Lot-et-Garonne', 14),
//             (48, 'Lozère', 14),
//             (49, 'Maine-et-Loire', 15),
//             (50, 'Manche', 12),
//             (51, 'Marne', 6),
//             (52, 'Haute-Marne', 6),
//             (53, 'Mayenne', 15),
//             (54, 'Meurthe-et-Moselle', 6),
//             (55, 'Meuse', 6),
//             (56, 'Morbihan', 3),
//             (57, 'Moselle', 6),
//             (58, 'Nièvre', 2),
//             (59, 'Nord', 9),
//             (60, 'Oise', 9),
//             (61, 'Orne', 12),
//             (62, 'Pas-de-Calais', 9),
//             (63, 'Puy-de-Dôme', 1),
//             (64, 'Pyrénées-Atlantiques', 14),
//             (65, 'Hautes-Pyrénées', 14),
//             (66, 'Pyrénées-Orientales', 14),
//             (67, 'Bas-Rhin', 6),
//             (68, 'Haut-Rhin', 6),
//             (69, 'Rhône', 1),
//             (70, 'Haute-Saône', 2),
//             (71, 'Saône-et-Loire', 2),
//             (72, 'Sarthe', 15),
//             (73, 'Savoie', 1),
//             (74, 'Haute-Savoie', 1),
//             (75, 'Paris', 10),
//             (76, 'Seine-Maritime', 12),
//             (77, 'Seine-et-Marne', 10),
//             (78, 'Yvelines', 10),
//             (79, 'Deux-Sèvres', 15),
//             (80, 'Somme', 9),
//             (81, 'Tarn', 14),
//             (82, 'Tarn-et-Garonne', 14),
//             (83, 'Var', 16),
//             (84, 'Vaucluse', 16),
//             (85, 'Vendée', 15),
//             (86, 'Vienne', 14),
//             (87, 'Haute-Vienne', 14),
//             (88, 'Vosges', 6),
//             (89, 'Yonne', 2),
//             (90, 'Territoire de Belfort', 2),
//             (91, 'Essonne', 10),
//             (92, 'Hauts-de-Seine', 10),
//             (93, 'Seine-Saint-Denis', 10),
//             (94, 'Val-de-Marne', 10),
//             (95, 'Val-d''Oise', 10),
//             (971, 'Guadeloupe', 13),
//             (972, 'Martinique', 14),
//             (973, 'Guyane', 15),
//             (974, 'La Réunion', 16),
//             (976, 'Mayotte', 16);
//         ";
//         $conn->exec($insert_dept);
//         echo "Données insérées dans la table 'dept' avec succès.<br>";

//     } catch (PDOException $e) {
//         echo "Erreur lors de l'insertion des données : " . $e->getMessage() . "<br>";
//     } finally {
//         $conn = null; // Déconnexion
//     }
// }