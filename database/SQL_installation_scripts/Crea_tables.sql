CREATE TABLE
	Attributs (
		id INTEGER PRIMARY KEY AUTOINCREMENT,
		value_type TEXT,
		"key" TEXT (10) NOT NULL,
		name TEXT NOT NULL,
		unit TEXT,
		description TEXT,
		example TEXT
	);

CREATE TABLE
	Grouppings (
		id INTEGER PRIMARY KEY AUTOINCREMENT,
		nom TEXT NOT NULL,
		"type" INTEGER DEFAULT (0) NOT NULL,
		cle TEXT DEFAULT ('') NOT NULL
	);

CREATE TABLE
	Representations (
		id INTEGER PRIMARY KEY AUTOINCREMENT,
		name TEXT NOT NULL,
		poss_groupping INTEGER DEFAULT (0),
		visu_fichier TEXT DEFAULT ('text.php') NOT NULL
	);

CREATE TABLE
	Aggregations (
		id INTEGER PRIMARY KEY AUTOINCREMENT,
		nom TEXT NOT NULL,
		cle TEXT DEFAULT ('avg') NOT NULL
	);

CREATE TABLE
	Saves (
		id INTEGER PRIMARY KEY AUTOINCREMENT,
		createur_id INTEGER NOT NULL,
		date_debut Date NOT NULL,
		date_fin Date NOT NULL,
		date_debut_relatif Boolean NOT NULL,
		date_fin_relatif Boolean NOT NULL,
		params TEXT NOT NULL,
		components_save TEXT NOT NULL, --sauvegarde JSON avec une liste de tableaux contennants les paramètres des composants
		geo_save TEXT NOT NULL, --sauvegarde JSON avec un tableaux contennants les critères géographiques
		CONSTRAINT Dashboards_Creator_FK FOREIGN KEY (createur_id) REFERENCES Utilisateur (utilisateur_id) ON UPDATE CASCADE
	);

CREATE TABLE
	Dashboards (
		id INTEGER PRIMARY KEY AUTOINCREMENT,
		privatisation INTEGER DEFAULT (0) NOT NULL,
		createur_id INTEGER NOT NULL,
		immortalised_id INTEGER DEFAULT (NULL),
		original_id INTEGER DEFAULT (0) NOT NULL,
		date_debut Date DEFAULT ('0000-00-00') NOT NULL,
		date_fin Date DEFAULT ('0000-00-00') NOT NULL,
		date_debut_relatif Boolean DEFAULT (False) NOT NULL,
		date_fin_relatif Boolean DEFAULT (False) NOT NULL,
		params TEXT DEFAULT ('NOM_METEOTHEQUE'),
		CONSTRAINT Dashboards_Immortal_FK FOREIGN KEY (immortalised_id) REFERENCES Saves (id) ON UPDATE CASCADE,
		CONSTRAINT Dashboards_Saves_FK FOREIGN KEY (original_id) REFERENCES Saves (id) ON UPDATE CASCADE,
		CONSTRAINT Dashboards_Creator_FK FOREIGN KEY (createur_id) REFERENCES Utilisateur (utilisateur_id) ON UPDATE CASCADE
	);

CREATE TABLE
	Analyses (
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
	);

CREATE TABLE
	Composants (
		id INTEGER PRIMARY KEY AUTOINCREMENT,
		dashboard_id INTEGER NOT NULL,
		analysis_id INTEGER NOT NULL,
		params_affich TEXT DEFAULT (''),
		CONSTRAINT Composant_dashboard_Dashboards_FK FOREIGN KEY (dashboard_id) REFERENCES Dashboards (id) ON DELETE CASCADE ON UPDATE CASCADE,
		CONSTRAINT Composant_dashboard_Composants_FK FOREIGN KEY (analysis_id) REFERENCES Analyses (id) ON DELETE CASCADE ON UPDATE CASCADE
	);

CREATE TABLE
	CritereGeo_dashboard (
		dashboard_id INTEGER NOT NULL,
		type_critere INTEGER NOT NULL,
		critere_id INTEGER NOT NULL,
		CONSTRAINT NewTable_PK PRIMARY KEY (dashboard_id, type_critere, critere_id),
		CONSTRAINT NewTable_Dashboards_FK FOREIGN KEY (dashboard_id) REFERENCES Dashboards (id) ON DELETE CASCADE ON UPDATE CASCADE
	);

CREATE TABLE
	regions (
		id INTEGER PRIMARY KEY AUTOINCREMENT,
		name TEXT NOT NULL
	);

CREATE TABLE
	depts (
		id TEXT PRIMARY KEY,
		name TEXT NOT NULL,
		reg_id INTEGER,
		FOREIGN KEY (reg_id) REFERENCES regions (id)
	);

CREATE TABLE
	epcis (
		id INTEGER PRIMARY KEY AUTOINCREMENT,
		name TEXT NOT NULL,
		dept_id INTEGER,
		FOREIGN KEY (dept_id) REFERENCES depts (id)
	);

CREATE TABLE
	villes (
		id TEXT PRIMARY KEY,
		name TEXT NOT NULL,
		epci_id INTEGER,
		FOREIGN KEY (epci_id) REFERENCES epcis (id)
	);

CREATE TABLE
	stations (
		id INTEGER PRIMARY KEY AUTOINCREMENT,
		name TEXT NOT NULL,
		latitude INTEGER,
		longitude INTEGER,
		ville_id INTEGER,
		FOREIGN KEY (ville_id) REFERENCES villes (id)
	);

CREATE TABLE
	utilisateur (
		utilisateur_id INTEGER PRIMARY KEY AUTOINCREMENT,
		utilisateur_pseudo TEXT NOT NULL,
		utilisateur_nom TEXT NOT NULL,
		utilisateur_prenom TEXT NOT NULL,
		utilisateur_mdp TEXT NOT NULL,
		utilisateur_mail TEXT NOT NULL UNIQUE, -- L'email doit être unique
		utilisateur_amis TEXT,
		utilisateur_nb_conn INTEGER DEFAULT 0,
		created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
	);