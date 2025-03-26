<?php

use Src\Config\ServerConf\DatabaseConnection;
// 1. Renommer les anciennes tables pour sécuriser
$query = "ALTER TABLE Composants RENAME TO Composants_old;";
DatabaseConnection::executeQuery($query);
$query = "ALTER TABLE Composant_dashboard RENAME TO Composant_dashboard_old;";
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

// 6. Suppression des tables renommées après vérification
$query = "DROP TABLE Composants_old;";
DatabaseConnection::executeQuery($query);
$query = "DROP TABLE Composant_dashboard_old;";
DatabaseConnection::executeQuery($query);
