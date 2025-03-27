<?php

use Src\Config\ServerConf\DatabaseConnection;
// 0. Renommer les anciennes tables pour sécuriser
$query = "ALTER TABLE Composants RENAME TO Composants_old;";
DatabaseConnection::executeQuery($query);
$query = "ALTER TABLE Composant_dashboard RENAME TO Composant_dashboard_old;";
DatabaseConnection::executeQuery($query);
$query = "ALTER TABLE Dashboards RENAME TO Dashboards_old;";
DatabaseConnection::executeQuery($query);

// 1. Revoir la table dashboards (ajout createur et original)
$query = "CREATE TABLE Dashboards (
		id INTEGER PRIMARY KEY AUTOINCREMENT,
		privatisation INTEGER DEFAULT (0) NOT NULL,
		createur_id INTEGER NOT NULL,
		original_id INTEGER DEFAULT (1) NOT NULL,
		date_debut Date DEFAULT ('0000-00-00') NOT NULL,
		date_fin Date DEFAULT ('0000-00-00') NOT NULL,
		date_debut_relatif Boolean DEFAULT (False) NOT NULL,
		date_fin_relatif Boolean DEFAULT (False) NOT NULL,
		params TEXT DEFAULT ('NOM_METEOTHEQUE'),
		CONSTRAINT Dashboards_Saves_FK FOREIGN KEY (original_id) REFERENCES Dashboards (id) ON UPDATE CASCADE,
		CONSTRAINT Dashboards_Creator_FK FOREIGN KEY (createur_id) REFERENCES Utilisateur (utilisateur_id) ON UPDATE CASCADE
	);";
DatabaseConnection::executeQuery($query);
$query = "INSERT INTO Dashboards (privatisation, createur_id, original_id, date_debut, date_fin, date_debut_relatif, date_fin_relatif, params)
SELECT privatisation, 0, 1, date_debut, date_fin, date_debut_relatif, date_fin_relatif, params FROM Dashboards_old;";
DatabaseConnection::executeQuery($query);
// netoyer les composants qui auraient déja du etres supprimés (c la faute a corentin, il avait pas bien fait son travail auparavant)
$query = "DELETE FROM Composant_dashboard_old
WHERE dashboard_id NOT IN (SELECT id FROM Dashboards);";
DatabaseConnection::executeQuery($query);
// MAJ des nouveaux dash_id
$query = "UPDATE Composant_dashboard_old
SET dashboard_id = (
    SELECT d_new.id 
    FROM Dashboards d_old
    JOIN Dashboards d_new 
    ON d_old.privatisation = d_new.privatisation
    AND d_old.date_debut = d_new.date_debut
    AND d_old.date_fin = d_new.date_fin
    AND d_old.date_debut_relatif = d_new.date_debut_relatif
    AND d_old.date_fin_relatif = d_new.date_fin_relatif
    AND d_old.params = d_new.params
    WHERE d_old.id = dashboard_id
)";
DatabaseConnection::executeQuery($query);

// 2. Créer la table Analyses (ex-Composants sans le params_affich et sans dashboard)
$query = "CREATE TABLE Analyses (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    repr_type INTEGER DEFAULT (2) NOT NULL,
    attribut INTEGER DEFAULT (1) NOT NULL,
    aggregation INTEGER DEFAULT (1) NOT NULL,
    groupping INTEGER DEFAULT (12) NOT NULL,
    CONSTRAINT specific_analysis UNIQUE (repr_type, attribut, aggregation, groupping),
    CONSTRAINT Composants_Aggregations_FK FOREIGN KEY (aggregation) REFERENCES Aggregations (id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT Composants_Grouppings_FK FOREIGN KEY (groupping) REFERENCES Grouppings (id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT Composants_Attributs_FK FOREIGN KEY (attribut) REFERENCES Attributs (id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT Composants_Representations_FK FOREIGN KEY (repr_type) REFERENCES Representations (id) ON DELETE CASCADE ON UPDATE CASCADE
);";
DatabaseConnection::executeQuery($query);

// 3. Insérer les données Composants vers Analyses (en ignorant params_affich)
$query = "INSERT OR IGNORE INTO Analyses (repr_type, attribut, aggregation, groupping)
SELECT repr_type, attribut, aggregation, groupping FROM Composants_old;";
DatabaseConnection::executeQuery($query);

// 4. Créer la nouvelle table Composants (pivot entre dashboard et analysis)
$query = "CREATE TABLE Composants (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    dashboard_id INTEGER NOT NULL,
    analysis_id INTEGER NOT NULL,
    params_affich TEXT DEFAULT (''),
    CONSTRAINT Composant_dashboard_Dashboards_FK FOREIGN KEY (dashboard_id) REFERENCES Dashboards (id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT Composant_dashboard_Composants_FK FOREIGN KEY (analysis_id) REFERENCES Analyses (id) ON DELETE CASCADE ON UPDATE CASCADE
);";
DatabaseConnection::executeQuery($query);

// 5. Reconstituer les nouveaux composants (dashboard_id + analysis_id)
$query = "INSERT INTO Composants (dashboard_id, analysis_id, params_affich)
SELECT cd.dashboard_id, a.id, c.params_affich
FROM Composants_old c
JOIN Composant_dashboard_old cd ON c.id = cd.composant_id
JOIN Analyses a ON c.repr_type = a.repr_type
               AND c.attribut = a.attribut
               AND c.aggregation = a.aggregation
               AND c.groupping = a.groupping;";
DatabaseConnection::executeQuery($query);

// 6. Recast critèresGéo parce qu'on a recast dashboards et perdu la FK
$query = "ALTER TABLE CritereGeo_dashboard RENAME TO old_CritereGeo_dashboard;";
DatabaseConnection::executeQuery($query);
$query = "CREATE TABLE CritereGeo_dashboard (
    dashboard_id INTEGER NOT NULL,
    type_critere INTEGER NOT NULL,
    critere_id INTEGER NOT NULL,
    CONSTRAINT NewTable_PK PRIMARY KEY (dashboard_id, type_critere, critere_id),
    CONSTRAINT NewTable_Dashboards_FK FOREIGN KEY (dashboard_id) REFERENCES Dashboards (id) ON DELETE CASCADE ON UPDATE CASCADE
);";
DatabaseConnection::executeQuery($query);
$query = "INSERT INTO CritereGeo_dashboard (dashboard_id, type_critere, critere_id)
SELECT dashboard_id, type_critere, critere_id FROM old_CritereGeo_dashboard;";
DatabaseConnection::executeQuery($query);

// 7. Suppression des tables renommées après vérification
$query = "DROP TABLE Composants_old;";
DatabaseConnection::executeQuery($query);
$query = "DROP TABLE Composant_dashboard_old;";
DatabaseConnection::executeQuery($query);
$query = "DROP TABLE Dashboards_old;";
DatabaseConnection::executeQuery($query);
$query = "DROP TABLE old_CritereGeo_dashboard;";
DatabaseConnection::executeQuery($query);
