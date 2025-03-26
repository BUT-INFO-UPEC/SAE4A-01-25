-- ===============================
-- SCRIPT DE DÉPLOIEMENT GLOBAL
-- ===============================

-- Suppression de la base si elle existe
DROP DATABASE IF EXISTS dev_meteoscop;

-- Création de la base
CREATE DATABASE dev_meteoscop CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Sélection de la base
USE dev_meteoscop;

-- ===============================
-- CREATION DES TABLES
-- ===============================

CREATE TABLE Attributs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    value_type VARCHAR(100),
    `key` VARCHAR(10) NOT NULL,
    name VARCHAR(100) NOT NULL,
    unit VARCHAR(100),
    description VARCHAR(100),
    example VARCHAR(100)
);

CREATE TABLE Grouppings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    `type` INT DEFAULT 0 NOT NULL,
    cle VARCHAR(100) DEFAULT '' NOT NULL
);

CREATE TABLE Representations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    poss_groupping INT DEFAULT 0,
    visu_fichier VARCHAR(100) DEFAULT 'text.php'
);

CREATE TABLE Aggregations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    cle VARCHAR(100) DEFAULT 'avg' NOT NULL
);

CREATE TABLE Saves (
    id INT AUTO_INCREMENT PRIMARY KEY,
    createur_id INT NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    date_debut_relatif TINYINT(1) NOT NULL,
    date_fin_relatif TINYINT(1) NOT NULL,
    params VARCHAR(100) NOT NULL,
    components_save VARCHAR(100) NOT NULL,
    geo_save VARCHAR(100) NOT NULL,
    CONSTRAINT Dashboards_Creator_FK FOREIGN KEY (createur_id) REFERENCES Utilisateur (utilisateur_id) ON UPDATE CASCADE
);

CREATE TABLE Dashboards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    privatisation INT DEFAULT 0 NOT NULL,
    createur_id INT NOT NULL,
    immortalised_id INT DEFAULT NULL,
    original_id INT DEFAULT 0 NOT NULL,
    date_debut DATE DEFAULT '0000-00-00' NULL NOT NULL,
    date_fin DATE DEFAULT '0000-00-00' NULL NOT NULL,
    date_debut_relatif TINYINT(1) DEFAULT 0 NOT NULL,
    date_fin_relatif TINYINT(1) DEFAULT 0 NOT NULL,
    params VARCHAR(100) DEFAULT 'NOM_METEOTHEQUE',
    CONSTRAINT Dashboards_Immortal_FK FOREIGN KEY (immortalised_id) REFERENCES Saves (id) ON UPDATE CASCADE,
    CONSTRAINT Dashboards_Saves_FK FOREIGN KEY (original_id) REFERENCES Saves (id) ON UPDATE CASCADE,
    CONSTRAINT Dashboards_Creator_FK FOREIGN KEY (createur_id) REFERENCES Utilisateur (utilisateur_id) ON UPDATE CASCADE
);

CREATE TABLE Analyses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    repr_type INT DEFAULT 2 NOT NULL,
    attribut INT DEFAULT 1 NOT NULL,
    aggregation INT DEFAULT 1 NOT NULL,
    groupping INT DEFAULT 12 NOT NULL,
    CONSTRAINT specific_analysis UNIQUE (repr_type, attribut, aggregation, groupping),
    CONSTRAINT Composants_Aggregations_FK FOREIGN KEY (aggregation) REFERENCES Aggregations (id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT Composants_Grouppings_FK FOREIGN KEY (groupping) REFERENCES Grouppings (id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT Composants_Attributs_FK FOREIGN KEY (attribut) REFERENCES Attributs (id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT Composants_Representations_FK FOREIGN KEY (repr_type) REFERENCES Representations (id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Composants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dashboard_id INT NOT NULL,
    analysis_id INT NOT NULL,
    params_affich VARCHAR(100) DEFAULT '',
    CONSTRAINT Composant_dashboard_Dashboards_FK FOREIGN KEY (dashboard_id) REFERENCES Dashboards (id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT Composant_dashboard_Composants_FK FOREIGN KEY (analysis_id) REFERENCES Analyses (id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE CritereGeo_dashboard (
    dashboard_id INT NOT NULL,
    type_critere INT NOT NULL,
    critere_id INT NOT NULL,
    CONSTRAINT NewTable_PK PRIMARY KEY (dashboard_id, type_critere, critere_id),
    CONSTRAINT NewTable_Dashboards_FK FOREIGN KEY (dashboard_id) REFERENCES Dashboards (id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE regions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE depts (
    id VARCHAR(100) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    reg_id INT,
    FOREIGN KEY (reg_id) REFERENCES regions (id)
);

CREATE TABLE epcis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    dept_id INT,
    FOREIGN KEY (dept_id) REFERENCES depts (id)
);

CREATE TABLE villes (
    id VARCHAR(100) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    epci_id INT,
    FOREIGN KEY (epci_id) REFERENCES epcis (id)
);

CREATE TABLE stations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    latitude INT,
    longitude INT,
    ville_id INT,
    FOREIGN KEY (ville_id) REFERENCES villes (id)
);

CREATE TABLE utilisateur (
    utilisateur_id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_pseudo VARCHAR(100) NOT NULL,
    utilisateur_nom VARCHAR(100) NOT NULL,
    utilisateur_prenom VARCHAR(100) NOT NULL,
    utilisateur_mdp VARCHAR(100) NOT NULL,
    utilisateur_mail VARCHAR(100) NOT NULL UNIQUE, -- L'email doit être unique
    utilisateur_amis VARCHAR(100),
    utilisateur_nb_conn INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO regions 
VALUES(1,'Guadeloupe'),
(2,'Martinique'),
(3,'Guyane'),
(4,'La Réunion'),
(6,'Mayotte'),
(11,'Île-de-France'),
(24,'Centre-Val de Loire'),
(27,'Bourgogne-Franche-Comté'),
(28,'Normandie'),
(32,'Hauts-de-France'),
(44,'Grand Est'),
(52,'Pays de la Loire'),
(53,'Bretagne'),
(75,'Nouvelle-Aquitaine'),
(76,'Occitanie'),
(84,'Auvergne-Rhône-Alpes'),
(93,'Provence-Alpes-Côte d''Azur'),
(94,'Corse');

INSERT INTO depts 
VALUES(80,'Somme',32),
(59,'Nord',32),
(50,'Manche',28),
(14,'Calvados',28),
(76,'Seine-Maritime',28),
(51,'Marne',44),
(29,'Finistère',53),
(22,'Côtes-d''Armor',53),
(35,'Ille-et-Vilaine',53),
(61,'Orne',28),
(91,'Essonne',11),
(10,'Aube',44),
(54,'Meurthe-et-Moselle',44),
(67,'Bas-Rhin',44),
(56,'Morbihan',53),
(44,'Loire-Atlantique',52),
(37,'Indre-et-Loire',24),
(18,'Cher',24),
(21,'Côte-d''Or',27),
(68,'Haut-Rhin',44),
(17,'Charente-Maritime',75),
(86,'Vienne',75),
(87,'Haute-Vienne',75),
(63,'Puy-de-Dôme',84),
(43,'Haute-Loire',84),
(69,'Rhône',84),
(33,'Gironde',75),
(46,'Lot',76),
(12,'Aveyron',76),
(26,'Drôme',84),
(5,'Hautes-Alpes',93),
(40,'Landes',75),
(65,'Hautes-Pyrénées',76),
(9,'Ariège',76),
(31,'Haute-Garonne',76),
(34,'Hérault',76),
(13,'Bouches-du-Rhône',93),
(83,'Var',93),
(6,'Alpes-Maritimes',93),
(66,'Pyrénées-Orientales',76),
('2a','Corse-du-Sud',94),
('2b','Haute-Corse',94),
(974,'La Réunion',4),
(976,'Mayotte',6),
(971,'Guadeloupe',1),
(972,'Martinique',2),
(973,'Guyane',3);

INSERT INTO epcis 
VALUES(200070993,'CA de la Baie de Somme',80),
(245900410,'Métropole Européenne de Lille',59),
(200067205,'CA du Cotentin',50),
(200065597,'CU Caen la Mer',14),
(200023414,'Métropole Rouen Normandie',76),
(200067213,'CU du Grand Reims',51),
(242900314,'Brest Métropole',29),
(200065928,'CA Lannion-Trégor Communauté',22),
(243500139,'Rennes Métropole',35),
(246100663,'CU d''Alençon',61),
(200054781,'Métropole du Grand Paris',91),
(200069250,'CA Troyes Champagne Métropole',10),
(245400510,'CC du Pays de Colombey et du Sud Toulois',54),
(246700488,'Eurométropole de Strasbourg',67),
(245600465,'CC de Belle Ile en Mer',56),
(244400404,'Nantes Métropole',44),
(243700754,'Tours Métropole Val de Loire',37),
(241800507,'CA Bourges Plus',18),
(242100410,'Dijon Métropole',21),
(200066058,'CA Saint-Louis Agglomération',68),
(241700624,'CC de l''Ile d''Oléron',17),
(200069854,'CU du Grand Poitiers',86),
(248719312,'CU Limoges Métropole',87),
(246300701,'Clermont Auvergne Métropole',63),
(200073419,'CA du Puy-en-Velay',43),
(246900575,'CC de l''Est Lyonnais (CCEL)',69),
(243300316,'Bordeaux Métropole',33),
(244600482,'CC Quercy - Bouriane',46),
(241200567,'CC de Millau Grands Causses',12),
(200040459,'CA Montélimar Agglomération',26),
(200067742,'CC Serre-Ponçon',5),
(244000808,'CA Mont de Marsan Agglomération',40),
(200069300,'CA Tarbes-Lourdes-Pyrénées',65),
(200067940,'CC Couserans-Pyrénées',9),
(243100518,'Toulouse Métropole',31),
(243400470,'CA du Pays de l''Or',34),
(200054807,'Métropole d''Aix-Marseille-Provence',13),
(248300543,'Métropole Toulon-Provence-Méditerranée',83),
(200030195,'Métropole Nice Côte d''Azur',6),
(200027183,'CU Perpignan Méditerranée Métropole',66),
(242010056,'CA du Pays Ajaccien','2a'),
(200036499,'CC de Marana-Golo','2b'),
(249740119,'CA Intercommunale du Nord de la Réunion (CINOR)',974),
(200050532,'CC de Petite-Terre',976),
(200041507,'CA La Riviéra du Levant',971),
(200018653,'CA CAP Excellence',971),
(200041788,'CA du Pays Nord Martinique',972),
(249720061,'CA du Centre de la Martinique',972),
(249730037,'CC de l''Ouest Guyanais',973),
(249730045,'CA du Centre Littoral',973),
(249730052,'CC de l''Est Guyanais',973);

INSERT INTO villes 
VALUES(80001,'Abbeville',200070993),
(59256,'Fretin',245900410),
(50041,'La Hague',200067205),
(14137,'Carpiquet',200065597),
(76116,'Boos',200023414),
(51449,'Prunay',200067213),
(29075,'Guipavas',242900314),
(22168,'Perros-Guirec',200065928),
(35281,'Saint-Jacques-de-la-Lande',243500139),
(61077,'Cerisé',246100663),
(91027,'Athis-Mons',200054781),
(10030,'Barberey-Saint-Sulpice',200069250),
(54523,'Thuilley-aux-Groseilles',245400510),
(67212,'Holtzheim',246700488),
(56009,'Bangor',245600465),
(44150,'Saint-Aignan-Grandlieu',244400404),
(37179,'Parçay-Meslay',243700754),
(18033,'Bourges',241800507),
(21473,'Ouges',242100410),
(68042,'Blotzheim',200066058),
(17323,'Saint-Denis-d''Oléron',241700624),
(86194,'Poitiers',200069854),
(87085,'Limoges',248719312),
(63113,'Clermont-Ferrand',246300701),
(43062,'Chaspuzac',200073419),
(69299,'Colombier-Saugnieu',246900575),
(33281,'Mérignac',243300316),
(46127,'Gourdon',244600482),
(12145,'Millau',241200567),
(26198,'Montélimar',200040459),
(5046,'Embrun',200067742),
(40192,'Mont-de-Marsan',244000808),
(65284,'Louey',200069300),
(9289,'Lorp-Sentaraille',200067940),
(31069,'Blagnac',243100518),
(34154,'Mauguio',243400470),
(13054,'Marignane',200054807),
(83153,'Saint-Mandrier-sur-Mer',248300543),
(6088,'Nice',200030195),
(66136,'Perpignan',200027183),
('2a004','Ajaccio',242010056),
('2b148','Lucciana',200036499),
(97418,'Sainte-Marie',249740119),
(97615,'Pamandzi',200050532),
(97110,'La Désirade',200041507),
(97101,'Les Abymes',200018653),
(97230,'La Trinité',200041788),
(97213,'Le Lamentin',249720061),
(97311,'Saint-Laurent-du-Maroni',249730037),
(97307,'Matoury',249730045),
(97308,'Saint-Georges',249730052),
(97353,'Maripasoula',249730037);

INSERT INTO stations 
VALUES(7005,'ABBEVILLE',50.13600000000000278,1.834000000000000074,80001),
(7015,'LILLE-LESQUIN',50.57000000000000028,3.097500000000000142,59256),
(7020,'PTE DE LA HAGUE',49.72516699999999901,-1.939832999999999919,50041),
(7027,'CAEN-CARPIQUET',49.17999999999999972,-0.4561669999999999892,14137),
(7037,'ROUEN-BOOS',49.38300000000000267,1.181667000000000022,76116),
(7072,'REIMS-PRUNAY',49.20966700000000315,4.155332999999999721,51449),
(7110,'BREST-GUIPAVAS',48.4441670000000002,-4.411999999999999922,29075),
(7117,'PLOUMANAC''H',48.82583300000000292,-3.473167000000000115,22168),
(7130,'RENNES-ST JACQUES',48.06883299999999793,-1.733999999999999986,35281),
(7139,'ALENCON',48.44550000000000267,0.110167000000000001,61077),
(7149,'ORLY',48.71683300000000116,2.384332999999999814,91027),
(7168,'TROYES-BARBEREY',48.32466699999999805,4.019999999999999573,10030),
(7181,'NANCY-OCHEY',48.58100000000000306,5.959832999999999715,54523),
(7190,'STRASBOURG-ENTZHEIM',48.54950000000000187,7.640333000000000041,67212),
(7207,'BELLE ILE-LE TALUT',47.29433300000000173,-3.218332999999999889,56009),
(7222,'NANTES-BOUGUENAIS',47.14999999999999858,-1.608832999999999958,44150),
(7240,'TOURS',47.4444999999999979,0.7273330000000000072,37179),
(7255,'BOURGES',47.05916700000000219,2.359833000000000069,18033),
(7280,'DIJON-LONGVIC',47.26783300000000309,5.088333000000000438,21473),
(7299,'BALE-MULHOUSE',47.61433300000000201,7.509999999999999787,68042),
(7314,'PTE DE CHASSIRON',46.04683299999999946,-1.411499999999999977,17323),
(7335,'POITIERS-BIARD',46.59383299999999651,0.3143329999999999735,86194),
(7434,'LIMOGES-BELLEGARDE',45.86116700000000179,1.175000000000000044,87085),
(7460,'CLERMONT-FD',45.78683300000000144,3.149332999999999939,63113),
(7471,'LE PUY-LOUDES',45.07450000000000045,3.764000000000000234,43062),
(7481,'LYON-ST EXUPERY',45.72650000000000147,5.077833000000000041,69299),
(7510,'BORDEAUX-MERIGNAC',44.83066699999999827,-0.6913329999999999754,33281),
(7535,'GOURDON',44.74499999999999745,1.396666999999998992,46127),
(7558,'MILLAU',44.11849999999999738,3.019499999999999851,12145),
(7577,'MONTELIMAR',44.58116700000000065,4.732999999999999652,26198),
(7591,'EMBRUN',44.5656669999999977,6.50233300000000014,5046),
(7607,'MONT-DE-MARSAN',43.90983299999999901,-0.5001670000000000282,40192),
(7621,'TARBES-OSSUN',43.18800000000000238,0,65284),
(7627,'ST GIRONS',43.00533300000000025,1.106832999999999956,9289),
(7630,'TOULOUSE-BLAGNAC',43.62100000000000221,1.378832999999999976,31069),
(7643,'MONTPELLIER',43.57699999999999819,3.963166999999999885,34154),
(7650,'MARIGNANE',43.43766699999999759,5.216000000000000191,13054),
(7661,'CAP CEPET',43.07933299999999833,5.940832999999999587,83153),
(7690,'NICE',43.64883300000000333,7.208999999999999631,6088),
(7747,'PERPIGNAN',42.73716699999999947,2.87283299999999997,66136),
(7761,'AJACCIO',41.91799999999999927,8.792666999999999789,'2a004'),
(7790,'BASTIA',42.54066699999999913,9.48516700000000057,'2b148'),
(61968,'GLORIEUSES',-11.58266700000000071,47.28966700000000145,NULL),
(61970,'JUAN DE NOVA',-17.05466699999999846,42.7120000000000033,NULL),
(61972,'EUROPA',-22.34416699999999878,40.34066700000000339,NULL),
(61976,'TROMELIN',-15.88766700000000042,54.52066700000000309,NULL),
(61980,'GILLOT-AEROPORT',-20.89249999999999829,55.52866699999999867,97418),
(61996,'NOUVELLE AMSTERDAM',-37.7951669999999993,77.56916699999999309,NULL),
(61997,'CROZET',-46.43249999999999745,51.85666700000000162,NULL),
(61998,'KERGUELEN',-49.35233300000000156,70.24333300000000691,NULL),
(67005,'PAMANDZI',-12.80550000000000032,45.28283299999999655,97615),
(71805,'ST-PIERRE',46.76633300000000303,-56.17916699999999964,NULL),
(78890,'LA DESIRADE METEO',16.33500000000000085,-61.00399999999999779,97110),
(78894,'ST-BARTHELEMY METEO',17.90149999999999863,-62.85216700000000145,NULL),
(78897,'LE RAIZET AERO',16.26399999999999935,-61.51633300000000303,97101),
(78922,'TRINITE-CARAVEL',14.77449999999999975,-60.8753329999999977,97230),
(78925,'LAMENTIN-AERO',14.59533300000000011,-60.99566699999999742,97213),
(81401,'SAINT LAURENT',5.485500000000000042,-54.03166699999999878,97311),
(81405,'CAYENNE-MATOURY',4.822333000000000424,-52.36533299999999969,97307),
(81408,'SAINT GEORGES',3.890667000000000097,-51.80466700000000201,97308),
(81415,'MARIPASOULA',3.640166999999999931,-54.02833300000000349,97353),
(89642,'DUMONT D''URVILLE',-66.66316700000000139,140.0010000000000047,NULL);

INSERT INTO Attributs (value_type, `key`, name, example, unit, description) 
VALUES 
('decimal', 't', 'Température', '303.45', 'K', NULL),
('datetime', 'date', 'Date', NULL, NULL, ''),
('int', 'pmer', 'Pression au niveau mer', NULL, NULL, 'Pa'),
('decimal', 'tend', 'Variation de pression en 3 heures', '-10', NULL, 'Pa'),
('texte', 'cod_tend', 'Type de tendance barométrique', '8', NULL, ''),
('int', 'dd', 'degré', '110', NULL, ''),
('decimal', 'ff', 'Vitesse du vent moyen 10mn', '8.3', NULL, 'm/s'),
('decimal', 'td', 'Point de rosée', '294.25', NULL, 'K'),
('int', 'u', 'Humidité', '58', NULL, '%'),
('decimal', 'vv', 'Visibilité horizontale', '53550', NULL, 'm'),
('texte', 'ww', 'Temps présent', NULL, NULL, NULL),
('texte', 'w1', 'Temps passé 1', NULL, NULL, NULL),
('texte', 'w2', 'Temps passé 2', NULL, NULL, NULL),
('decimal', 'n', 'Nebulosité totale', NULL, NULL, '%'),
('texte', 'nbas', 'Nébulosité des nuages de l\'étage inférieur', NULL, NULL, 'octa'),
('decimal', 'hbas', 'Hauteur de la base des nuages de l\'étage inférieur', NULL, NULL, 'm'),
('texte', 'cl', 'Type des nuages de l\'étage inférieur', NULL, NULL, NULL),
('texte', 'cm', 'Type des nuages de l\'étage moyen', NULL, NULL, NULL),
('texte', 'ch', 'Type des nuages de l\'étage supérieur', NULL, NULL, NULL),
('decimal', 'pres', 'Pression station', '101740', 'Pa', NULL),
('decimal', 'niv_bar', 'Niveau barométrique', NULL, 'Pa', NULL),
('texte', 'geop', 'Géopotentiel', NULL, NULL, 'm2/s2'),
('decimal', 'tend24', 'Variation de pression en 24 heures', '-10', 'Pa', NULL),
('decimal', 'tn12', 'Température minimale sur 12 heures', NULL, NULL, 'K'),
('decimal', 'tn24', 'Température minimale sur 24 heures', NULL, NULL, 'K'),
('decimal', 'tx12', 'Température maximale sur 12 heures', NULL, NULL, 'K'),
('decimal', 'tx24', 'Température maximale sur 24 heures', NULL, NULL, 'K'),
('decimal', 'tminsol', 'Température minimale du sol sur 12 heures', NULL, NULL, 'K'),
('texte', 'sw', 'Méthode de mesure Température du thermomètre mouillé', '', NULL, NULL),
('decimal', 'tw', 'Température du thermomètre mouillé', NULL, NULL, 'K'),
('decimal', 'raf10', 'Rafale sur les 10 dernières minutes', NULL, NULL, 'm/s'),
('decimal', 'rafper', 'Rafales sur une période', NULL, 'm/s', 'm/s'),
('decimal', 'per', 'Periode de mesure de la rafale', NULL, 'minutes', 'min'),
('texte', 'etat_sol', 'Etat du sol', '', NULL, NULL),
('decimal', 'ht_neige', 'Hauteur totale de la couche de neige, glace, autre au sol', NULL, 'm', 'm'),
('decimal', 'ssfrai', 'Hauteur de la neige fraîche', NULL, 'm', 'm'),
('decimal', 'perssfrai', 'Periode de mesure de la neige fraiche', NULL, NULL, '1/10 heure'),
('decimal', 'rr1', 'Précipitations dans la dernière heure', '0', 'mm', 'mm'),
('decimal', 'rr3', 'Précipitations dans les 3 dernières heures', '0', 'mm', 'mm'),
('decimal', 'rr6', 'Précipitations dans les 6 dernières heures', '0', 'mm', 'mm'),
('decimal', 'rr12', 'Précipitations dans les 12 dernières heures', '-0.1', 'mm', 'mm'),
('decimal', 'rr24', 'Précipitations dans les 24 dernières heures', '-0.1', 'mm', 'mm'),
('decimal', 'phenspe1', 'Phénomène spécial 1', NULL, NULL, NULL),
('decimal', 'phenspe2', 'Phénomène spécial 2', NULL, NULL, NULL),
('decimal', 'phenspe3', 'Phénomène spécial 3', NULL, NULL, NULL),
('texte', 'phenspe4', 'Phénomène spécial 4', NULL, NULL, NULL),
('decimal', 'nnuage1', 'Nébulosité couche nuageuse 1', NULL, NULL, 'octa'),
('texte', 'ctype1', 'Type nuage 1', NULL, NULL, NULL),
('decimal', 'hnuage1', 'Hauteur de base 1', NULL, 'm', 'm'),
('decimal', 'nnuage2', 'Nébulosité couche nuageuse 2', NULL, NULL, 'octa'),
('texte', 'ctype2', 'Type nuage 2', '', NULL, NULL),
('decimal', 'hnuage2', 'Hauteur de base 2', NULL, 'm', 'm'),
('decimal', 'nnuage3', 'Nébulosité couche nuageuse 3', NULL, NULL, 'octa'),
('texte', 'ctype3', 'Type nuage 3', '', NULL, NULL),
('decimal', 'hnuage3', 'Hauteur de base 3', NULL, 'm', 'm'),
('texte', 'nnuage4', 'Nébulosité couche nuageuse 4', '', NULL, 'octa'),
('texte', 'ctype4', 'Type nuage 4', '', NULL, NULL),
('decimal', 'hnuage4', 'Hauteur de base 4', NULL, 'm', 'm'),
('geo_point_2d', 'coordonnees', 'Coordonnees', '[14.595333, -60.995667]', NULL, NULL),
('texte', 'nom', 'Nom', 'LAMENTIN-AERO', NULL, NULL),
('texte', 'type_de_tendance_barometrique', 'Type de tendance barométrique', 'Stationnaire ou en hausse, puis en baisse, ou en baisse, puis en baisse plus rapide', NULL, NULL),
('texte', 'temps_passe_1', 'Temps présent', NULL, NULL, NULL),
('texte', 'temps_present', 'Temps passé 1', NULL, NULL, NULL),
('decimal', 'tc', 'Température', '0.30000000000001', '°C', NULL),
('decimal', 'tn12c', 'Température minimale sur 12 heures', NULL, '°C', NULL),
('decimal', 'tn24c', 'Température minimale sur 24 heures', NULL, '°C', NULL),
('decimal', 'tx12c', 'Température maximale sur 12 heures', NULL, '°C', NULL),
('decimal', 'tx24c', 'Température maximale sur 12 heures', NULL, '°C', NULL),
('decimal', 'tminsolc', 'Température minimale du sol sur 12 heures', NULL, '°C', NULL),
('decimal', 'latitude', 'Latitude', '14.595333', NULL, NULL),
('decimal', 'longitude', 'Longitude', '-60.995667', NULL, NULL),
('int', 'altitude', 'Altitude', '3', NULL, NULL),
('decimal', 'longitude', 'Longitude', '-60.995667', NULL, NULL),
('texte', 'libgeo', 'communes (name)', 'Le Lamentin', NULL, NULL),
('texte', 'codegeo', 'communes (code)', '97213', NULL, NULL),
('texte', 'nom_epci', 'EPCI (name)', 'CA du Centre de la Martinique', NULL, NULL),
('texte', 'code_epci', 'EPCI (code)', '249720061', NULL, NULL),
('texte', 'code_dep', 'department (code)', '972', NULL, NULL),
('texte', 'nom_reg', 'region (name)', 'Martinique', NULL, NULL),
('texte', 'CODE_reg', 'region (code)', '02', NULL, NULL),
('int', 'mois_de_l_annee', 'mois_de_l_annee', '4', NULL, NULL);

-- Insertion dans la table Grouppings
INSERT INTO Grouppings (nom, type, cle) 
VALUES ('ANNEE', 'temporel', ''),
('SAISONS', 'temporel', ''),
('SOMMEPARMOIS', 'temporel', 'MONTH(date)'),
('MOIS', 'temporel', 'YEAR(date),MONTH(date)'),
('SEMAINES', 'temporel', ''),
('JOURS', 'temporel', ''),
('LISTE_DATES', 'temporel', ''),
('REGION', 'temporel', ''),
('DEPARTEMENT', 'geographique', ''),
('COMMUNES', 'geographique', ''),
('LISTE_STATIONS', 'geographique', ''),
('*', '', '');

-- Insertion dans la table Representations
INSERT INTO Representations (name, poss_groupping, visu_fichier) 
VALUES ('graphique circulaire', NULL, 'generate_pie_chart.php'),
('donnée textuelle', NULL, 'generate_text_representation.php'),
('carte', NULL, 'generate_geo_chart.php'),
('courbe', NULL, 'generate_line_chart.php'),
('histograme', NULL, 'generate_bar_chart.php');

-- Insertion dans la table Aggregations
INSERT INTO Aggregations (nom, cle) 
VALUES ('Moyenne', 'avg'),
('Maximum', 'max'),
('Minimum', 'min'),
('Somme', 'sum'),
('Enumérer', 'count');

-- Insertion dans la table Dashboards
INSERT INTO Dashboards (createur_id, immortalised_id, date_debut, date_fin, date_debut_relatif, date_fin_relatif, params) 
VALUES (0, 0, '0000-00-14', '0000-00-07', True, True, '{"title": "Dashboard initial"}');

-- Insertion dans la table Saves
INSERT INTO Saves (id, createur_id, date_debut, date_fin, date_debut_relatif, date_fin_relatif, params, components_save, geo_save) 
VALUES (0, 0, '0000-00-14', '0000-00-07', True, True, '{"title": "Dashboard initial"}', '[{"representation": "generate_text_representation.php", "attribut": "t", "aggregation":"avg","groupping": ""}]', '{"numer_sta": "78925"}');

-- Insertion dans la table Analyses
INSERT INTO Analyses (repr_type, attribut, aggregation, groupping) 
VALUES (2, 1, 1, 3);

-- Insertion dans la table Composants
INSERT INTO Composants (dashboard_id, analysis_id, params_affich) 
VALUES (0 ,0, '{"titre":"coucou", "chartId":0}');

-- Insertion dans la table CritereGeo_dashboard
INSERT INTO CritereGeo_dashboard (dashboard_id, type_critere, critere_id) 
VALUES ( 0, 0, "78925");

-- Insertion dans la table utilisateur (utilisateurs multiples)
INSERT INTO utilisateur (utilisateur_id, utilisateur_pseudo, utilisateur_mdp, utilisateur_mail, created_at, utilisateur_nom, utilisateur_prenom) 
VALUES (0,"DefaultUser","vitrygtr","admin@meteoscope.fr","0000-00-00 00:00:00","ADMINISTRATEUR","Deboggeur");

-- Insertion d'utilisateurs supplémentaires
INSERT INTO utilisateur (utilisateur_pseudo, utilisateur_mdp, utilisateur_mail, utilisateur_amis, created_at, utilisateur_nom, utilisateur_prenom, utilisateur_nb_conn) 
VALUES
    ('Kirito_140','max111005','maxence.campourcy@etu.u-pec.fr',NULL,'2025-01-23 11:55:58','Campourcy','Maxence',8),
    ('JD','123','a@b.c',NULL,'2025-01-23 15:44:16','Doe','John',10),
    ('Shadow','12345','amine.bouras33@gmail.com',NULL,'2025-01-24 09:49:19','Bouras','Mohamed Amine',0);

-- Insertion d'autres utilisateurs
INSERT INTO utilisateur (utilisateur_pseudo, utilisateur_mdp, utilisateur_mail, utilisateur_amis, utilisateur_nom, utilisateur_prenom, utilisateur_nb_conn) 
VALUES
    ('D','12345','dishabh10@gmail.com',NULL,'Bh','Dsh',0),
    ('Lga','TestSAE2025','ahmed.sadoudi@etu.u-pec.fr',NULL,'Ahmed','Sadoudi',0);
