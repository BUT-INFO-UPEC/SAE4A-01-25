INSERT INTO Attributs (value_type, key, name, example, unit, description) 
VALUES ('decimal ', 't', 'Température', '303.45', 'K', NULL),
('datetime', 'date', 'Date', NULL, NULL, ''),
('int', 'pmer', 'Pression au niveau mer', NULL, NULL, 'Pa'),
('décimal', 'tend', 'Variation de pression en 3 heures', '-10', NULL, 'Pa'),
('texte', 'cod_tend', 'Type de tendance barométrique', '8', NULL, ''),
('int', 'dd', 'degré', '110', NULL, ''),
('décimal', 'ff', 'Vitesse du vent moyen 10mn', '8.3', NULL, 'm/s'),
('decimal K', 'td', 'Point de rosée', '294.25', NULL, 'K'),
('int', 'u', 'Humidité', '58', NULL, '%'),
('decimal', 'vv', 'Visibilité horizontale', '53550', NULL, 'm'),
('texte', 'ww', 'Temps présent', NULL, NULL, NULL),
('texte', 'w1', 'Temps passé 1', NULL, NULL, NULL),
('texte', 'w2', 'Temps passé 2', NULL, NULL, NULL),
('decimal', 'n', 'Nebulosité totale', NULL, NULL, '%'),
('texte', 'nbas', 'Nébulosité des nuages de l''étage inférieur', NULL, NULL, 'octa'),
('decimal', 'hbas', 'Hauteur de la base des nuages de l''étage inférieur', NULL, NULL, 'm'),
('texte', 'cl', 'Type des nuages de l''étage inférieur', NULL, NULL, NULL),
('texte', 'cm', 'Type des nuages de l''étage moyen', NULL, NULL, NULL),
('texte', 'ch', 'Type des nuages de l''étage supérieur', NULL, NULL, NULL),
('decimal', 'pres', 'Pression station', '101740', 'Pa', NULL),
('decimal Pa', 'niv_bar', 'Niveau barométrique', NULL, 'Pa', NULL),
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
('decimal m/s', 'rafper', 'Rafales sur une période', NULL, 'm/s', 'm/s'),
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
('décimal', 'phenspe1', 'Phénomène spécial 1', NULL, NULL, NULL),
('décimal', 'phenspe2', 'Phénomène spécial 2', NULL, NULL, NULL),
('décimal', 'phenspe3', 'Phénomène spécial 3', NULL, NULL, NULL),
('texte', 'phenspe4', 'Phénomène spécial 4', NULL, NULL, NULL),
('decimal', 'nnuage1', 'Nébulosité couche nuageuse 1', NULL, NULL, 'octa'),
('texte', 'ctype1', 'Type nuage 1', NULL, NULL, NULL),
('decimal m', 'hnuage1', 'Hauteur de base 1', NULL, 'm', 'm'),
('decimal', 'nnuage2', 'Nébulosité couche nuageuse 2', NULL, NULL, 'octa'),
('texte', 'ctype2', 'Type nuage 2', '', NULL, NULL),
('decimal m', 'hnuage2', 'Hauteur de base 2', NULL, 'm', 'm'),
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
('décimal', 'tc', 'Température', '0.30000000000001', '°C', NULL),
('décimal', 'tn12c', 'Température minimale sur 12 heures', NULL, '°C', NULL),
('décimal', 'tn24c', 'Température minimale sur 24 heures', NULL, '°C', NULL),
('décimal', 'tx12c', 'Température maximale sur 12 heures', NULL, '°C', NULL),
('décimal', 'tx24c', 'Température maximale sur 12 heures', NULL, '°C', NULL),
('décimal', 'tminsolc', 'Température minimale du sol sur 12 heures', NULL, '°C', NULL),
('décimal', 'latitude', 'Latitude', '14.595333', NULL, NULL),
('décimal', 'longitude', 'Longitude', '-60.995667', NULL, NULL),
('int', 'altitude', 'Altitude', '3', NULL, NULL),
('décimal', 'longitude', 'Longitude', '-60.995667', NULL, NULL),
('texte', 'libgeo', 'communes (name)', 'Le Lamentin', NULL, NULL),
('texte', 'codegeo', 'communes (code)', '97213', NULL, NULL),
('texte', 'nom_epci', 'EPCI (name)', 'CA du Centre de la Martinique', NULL, NULL),
('texte', 'code_epci', 'EPCI (code)', '249720061', NULL, NULL),
('texte', 'code_dep', 'department (code)', '972', NULL, NULL),
('texte', 'nom_reg', 'region (name)', 'Martinique', NULL, NULL),
('texte', 'CODE_reg', 'region (code)', '02', NULL, NULL),
('int', 'mois_de_l_annee', 'mois_de_l_annee', '4', NULL, NULL);

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

INSERT INTO Representations (name, poss_groupping, visu_fichier) 
VALUES ('graphique circulaire', NULL, 'generate_pie_chart.php'),
('donnée textuelle', NULL, 'generate_text_representation.php'),
('carte', NULL, 'generate_geo_chart.php'),
('courbe', NULL, 'generate_line_chart.php'),
('histograme', NULL, 'generate_bar_chart.php');

INSERT INTO Aggregations (nom, cle) 
VALUES ('Moyenne', 'avg'),
('Maximum', 'max'),
('Minimum', 'min'),
('Somme', 'sum'),
('Enumérer', 'count');