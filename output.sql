PRAGMA foreign_keys = OFF;

BEGIN TRANSACTION;

CREATE TABLE
	regions (
		id INTEGER PRIMARY KEY AUTOINCREMENT,
		name TEXT NOT NULL
	);

INSERT INTO
	regions
VALUES
	(1, 'Guadeloupe');

INSERT INTO
	regions
VALUES
	(2, 'Martinique');

INSERT INTO
	regions
VALUES
	(3, 'Guyane');

INSERT INTO
	regions
VALUES
	(4, 'La R├®union');

INSERT INTO
	regions
VALUES
	(6, 'Mayotte');

INSERT INTO
	regions
VALUES
	(11, '├Äle-de-France');

INSERT INTO
	regions
VALUES
	(24, 'Centre-Val de Loire');

INSERT INTO
	regions
VALUES
	(27, 'Bourgogne-Franche-Comt├®');

INSERT INTO
	regions
VALUES
	(28, 'Normandie');

INSERT INTO
	regions
VALUES
	(32, 'Hauts-de-France');

INSERT INTO
	regions
VALUES
	(44, 'Grand Est');

INSERT INTO
	regions
VALUES
	(52, 'Pays de la Loire');

INSERT INTO
	regions
VALUES
	(53, 'Bretagne');

INSERT INTO
	regions
VALUES
	(75, 'Nouvelle-Aquitaine');

INSERT INTO
	regions
VALUES
	(76, 'Occitanie');

INSERT INTO
	regions
VALUES
	(84, 'Auvergne-Rh├┤ne-Alpes');

INSERT INTO
	regions
VALUES
	(93, 'Provence-Alpes-C├┤te d''Azur');

INSERT INTO
	regions
VALUES
	(94, 'Corse');

CREATE TABLE
	depts (
		id INTEGER,
		name TEXT NOT NULL,
		reg_id INTEGER,
		FOREIGN KEY (reg_id) REFERENCES regions (id)
	);

INSERT INTO
	depts
VALUES
	(80, 'Somme', 32);

INSERT INTO
	depts
VALUES
	(59, 'Nord', 32);

INSERT INTO
	depts
VALUES
	(50, 'Manche', 28);

INSERT INTO
	depts
VALUES
	(14, 'Calvados', 28);

INSERT INTO
	depts
VALUES
	(76, 'Seine-Maritime', 28);

INSERT INTO
	depts
VALUES
	(51, 'Marne', 44);

INSERT INTO
	depts
VALUES
	(29, 'Finist├¿re', 53);

INSERT INTO
	depts
VALUES
	(22, 'C├┤tes-d''Armor', 53);

INSERT INTO
	depts
VALUES
	(35, 'Ille-et-Vilaine', 53);

INSERT INTO
	depts
VALUES
	(61, 'Orne', 28);

INSERT INTO
	depts
VALUES
	(91, 'Essonne', 11);

INSERT INTO
	depts
VALUES
	(10, 'Aube', 44);

INSERT INTO
	depts
VALUES
	(54, 'Meurthe-et-Moselle', 44);

INSERT INTO
	depts
VALUES
	(67, 'Bas-Rhin', 44);

INSERT INTO
	depts
VALUES
	(56, 'Morbihan', 53);

INSERT INTO
	depts
VALUES
	(44, 'Loire-Atlantique', 52);

INSERT INTO
	depts
VALUES
	(37, 'Indre-et-Loire', 24);

INSERT INTO
	depts
VALUES
	(18, 'Cher', 24);

INSERT INTO
	depts
VALUES
	(21, 'C├┤te-d''Or', 27);

INSERT INTO
	depts
VALUES
	(68, 'Haut-Rhin', 44);

INSERT INTO
	depts
VALUES
	(17, 'Charente-Maritime', 75);

INSERT INTO
	depts
VALUES
	(86, 'Vienne', 75);

INSERT INTO
	depts
VALUES
	(87, 'Haute-Vienne', 75);

INSERT INTO
	depts
VALUES
	(63, 'Puy-de-D├┤me', 84);

INSERT INTO
	depts
VALUES
	(43, 'Haute-Loire', 84);

INSERT INTO
	depts
VALUES
	(69, 'Rh├┤ne', 84);

INSERT INTO
	depts
VALUES
	(33, 'Gironde', 75);

INSERT INTO
	depts
VALUES
	(46, 'Lot', 76);

INSERT INTO
	depts
VALUES
	(12, 'Aveyron', 76);

INSERT INTO
	depts
VALUES
	(26, 'Dr├┤me', 84);

INSERT INTO
	depts
VALUES
	(5, 'Hautes-Alpes', 93);

INSERT INTO
	depts
VALUES
	(40, 'Landes', 75);

INSERT INTO
	depts
VALUES
	(65, 'Hautes-Pyr├®n├®es', 76);

INSERT INTO
	depts
VALUES
	(9, 'Ari├¿ge', 76);

INSERT INTO
	depts
VALUES
	(31, 'Haute-Garonne', 76);

INSERT INTO
	depts
VALUES
	(34, 'H├®rault', 76);

INSERT INTO
	depts
VALUES
	(13, 'Bouches-du-Rh├┤ne', 93);

INSERT INTO
	depts
VALUES
	(83, 'Var', 93);

INSERT INTO
	depts
VALUES
	(6, 'Alpes-Maritimes', 93);

INSERT INTO
	depts
VALUES
	(66, 'Pyr├®n├®es-Orientales', 76);

INSERT INTO
	depts
VALUES
	('2a', 'Corse-du-Sud', 94);

INSERT INTO
	depts
VALUES
	('2b', 'Haute-Corse', 94);

INSERT INTO
	depts
VALUES
	(974, 'La R├®union', 4);

INSERT INTO
	depts
VALUES
	(976, 'Mayotte', 6);

INSERT INTO
	depts
VALUES
	(971, 'Guadeloupe', 1);

INSERT INTO
	depts
VALUES
	(971, 'Guadeloupe', 1);

INSERT INTO
	depts
VALUES
	(972, 'Martinique', 2);

INSERT INTO
	depts
VALUES
	(972, 'Martinique', 2);

INSERT INTO
	depts
VALUES
	(973, 'Guyane', 3);

INSERT INTO
	depts
VALUES
	(973, 'Guyane', 3);

INSERT INTO
	depts
VALUES
	(973, 'Guyane', 3);

INSERT INTO
	depts
VALUES
	(973, 'Guyane', 3);

CREATE TABLE
	epcis (
		id INTEGER,
		name TEXT NOT NULL,
		dept_id INTEGER,
		FOREIGN KEY (dept_id) REFERENCES depts (id)
	);

INSERT INTO
	epcis
VALUES
	(200070993, 'CA de la Baie de Somme', 80);

INSERT INTO
	epcis
VALUES
	(245900410, 'M├®tropole Europ├®enne de Lille', 59);

INSERT INTO
	epcis
VALUES
	(200067205, 'CA du Cotentin', 50);

INSERT INTO
	epcis
VALUES
	(200065597, 'CU Caen la Mer', 14);

INSERT INTO
	epcis
VALUES
	(200023414, 'M├®tropole Rouen Normandie', 76);

INSERT INTO
	epcis
VALUES
	(200067213, 'CU du Grand Reims', 51);

INSERT INTO
	epcis
VALUES
	(242900314, 'Brest M├®tropole', 29);

INSERT INTO
	epcis
VALUES
	(200065928, 'CA Lannion-Tr├®gor Communaut├®', 22);

INSERT INTO
	epcis
VALUES
	(243500139, 'Rennes M├®tropole', 35);

INSERT INTO
	epcis
VALUES
	(246100663, 'CU d''Alen├ºon', 61);

INSERT INTO
	epcis
VALUES
	(200054781, 'M├®tropole du Grand Paris', 91);

INSERT INTO
	epcis
VALUES
	(200069250, 'CA Troyes Champagne M├®tropole', 10);

INSERT INTO
	epcis
VALUES
	(
		245400510,
		'CC du Pays de Colombey et du Sud Toulois',
		54
	);

INSERT INTO
	epcis
VALUES
	(246700488, 'Eurom├®tropole de Strasbourg', 67);

INSERT INTO
	epcis
VALUES
	(245600465, 'CC de Belle Ile en Mer', 56);

INSERT INTO
	epcis
VALUES
	(244400404, 'Nantes M├®tropole', 44);

INSERT INTO
	epcis
VALUES
	(243700754, 'Tours M├®tropole Val de Loire', 37);

INSERT INTO
	epcis
VALUES
	(241800507, 'CA Bourges Plus', 18);

INSERT INTO
	epcis
VALUES
	(242100410, 'Dijon M├®tropole', 21);

INSERT INTO
	epcis
VALUES
	(200066058, 'CA Saint-Louis Agglom├®ration', 68);

INSERT INTO
	epcis
VALUES
	(241700624, 'CC de l''Ile d''Ol├®ron', 17);

INSERT INTO
	epcis
VALUES
	(200069854, 'CU du Grand Poitiers', 86);

INSERT INTO
	epcis
VALUES
	(248719312, 'CU Limoges M├®tropole', 87);

INSERT INTO
	epcis
VALUES
	(246300701, 'Clermont Auvergne M├®tropole', 63);

INSERT INTO
	epcis
VALUES
	(200073419, 'CA du Puy-en-Velay', 43);

INSERT INTO
	epcis
VALUES
	(246900575, 'CC de l''Est Lyonnais (CCEL)', 69);

INSERT INTO
	epcis
VALUES
	(243300316, 'Bordeaux M├®tropole', 33);

INSERT INTO
	epcis
VALUES
	(244600482, 'CC Quercy - Bouriane', 46);

INSERT INTO
	epcis
VALUES
	(241200567, 'CC de Millau Grands Causses', 12);

INSERT INTO
	epcis
VALUES
	(200040459, 'CA Mont├®limar Agglom├®ration', 26);

INSERT INTO
	epcis
VALUES
	(200067742, 'CC Serre-Pon├ºon', 5);

INSERT INTO
	epcis
VALUES
	(244000808, 'CA Mont de Marsan Agglom├®ration', 40);

INSERT INTO
	epcis
VALUES
	(200069300, 'CA Tarbes-Lourdes-Pyr├®n├®es', 65);

INSERT INTO
	epcis
VALUES
	(200067940, 'CC Couserans-Pyr├®n├®es', 9);

INSERT INTO
	epcis
VALUES
	(243100518, 'Toulouse M├®tropole', 31);

INSERT INTO
	epcis
VALUES
	(243400470, 'CA du Pays de l''Or', 34);

INSERT INTO
	epcis
VALUES
	(
		200054807,
		'M├®tropole d''Aix-Marseille-Provence',
		13
	);

INSERT INTO
	epcis
VALUES
	(
		248300543,
		'M├®tropole Toulon-Provence-M├®diterran├®e',
		83
	);

INSERT INTO
	epcis
VALUES
	(200030195, 'M├®tropole Nice C├┤te d''Azur', 6);

INSERT INTO
	epcis
VALUES
	(
		200027183,
		'CU Perpignan M├®diterran├®e M├®tropole',
		66
	);

INSERT INTO
	epcis
VALUES
	(242010056, 'CA du Pays Ajaccien', '2a');

INSERT INTO
	epcis
VALUES
	(200036499, 'CC de Marana-Golo', '2b');

INSERT INTO
	epcis
VALUES
	(
		249740119,
		'CA Intercommunale du Nord de la R├®union (CINOR)',
		974
	);

INSERT INTO
	epcis
VALUES
	(200050532, 'CC de Petite-Terre', 976);

INSERT INTO
	epcis
VALUES
	(200041507, 'CA La Rivi├®ra du Levant', 971);

INSERT INTO
	epcis
VALUES
	(200018653, 'CA CAP Excellence', 971);

INSERT INTO
	epcis
VALUES
	(200041788, 'CA du Pays Nord Martinique', 972);

INSERT INTO
	epcis
VALUES
	(249720061, 'CA du Centre de la Martinique', 972);

INSERT INTO
	epcis
VALUES
	(249730037, 'CC de l''Ouest Guyanais', 973);

INSERT INTO
	epcis
VALUES
	(249730045, 'CA du Centre Littoral', 973);

INSERT INTO
	epcis
VALUES
	(249730052, 'CC de l''Est Guyanais', 973);

INSERT INTO
	epcis
VALUES
	(249730037, 'CC de l''Ouest Guyanais', 973);

CREATE TABLE
	villes (
		id INTEGER,
		name TEXT NOT NULL,
		epci_id INTEGER,
		FOREIGN KEY (epci_id) REFERENCES epcis (id)
	);

INSERT INTO
	villes
VALUES
	(80001, 'Abbeville', 200070993);

INSERT INTO
	villes
VALUES
	(59256, 'Fretin', 245900410);

INSERT INTO
	villes
VALUES
	(50041, 'La Hague', 200067205);

INSERT INTO
	villes
VALUES
	(14137, 'Carpiquet', 200065597);

INSERT INTO
	villes
VALUES
	(76116, 'Boos', 200023414);

INSERT INTO
	villes
VALUES
	(51449, 'Prunay', 200067213);

INSERT INTO
	villes
VALUES
	(29075, 'Guipavas', 242900314);

INSERT INTO
	villes
VALUES
	(22168, 'Perros-Guirec', 200065928);

INSERT INTO
	villes
VALUES
	(35281, 'Saint-Jacques-de-la-Lande', 243500139);

INSERT INTO
	villes
VALUES
	(61077, 'Ceris├®', 246100663);

INSERT INTO
	villes
VALUES
	(91027, 'Athis-Mons', 200054781);

INSERT INTO
	villes
VALUES
	(10030, 'Barberey-Saint-Sulpice', 200069250);

INSERT INTO
	villes
VALUES
	(54523, 'Thuilley-aux-Groseilles', 245400510);

INSERT INTO
	villes
VALUES
	(67212, 'Holtzheim', 246700488);

INSERT INTO
	villes
VALUES
	(56009, 'Bangor', 245600465);

INSERT INTO
	villes
VALUES
	(44150, 'Saint-Aignan-Grandlieu', 244400404);

INSERT INTO
	villes
VALUES
	(37179, 'Par├ºay-Meslay', 243700754);

INSERT INTO
	villes
VALUES
	(18033, 'Bourges', 241800507);

INSERT INTO
	villes
VALUES
	(21473, 'Ouges', 242100410);

INSERT INTO
	villes
VALUES
	(68042, 'Blotzheim', 200066058);

INSERT INTO
	villes
VALUES
	(17323, 'Saint-Denis-d''Ol├®ron', 241700624);

INSERT INTO
	villes
VALUES
	(86194, 'Poitiers', 200069854);

INSERT INTO
	villes
VALUES
	(87085, 'Limoges', 248719312);

INSERT INTO
	villes
VALUES
	(63113, 'Clermont-Ferrand', 246300701);

INSERT INTO
	villes
VALUES
	(43062, 'Chaspuzac', 200073419);

INSERT INTO
	villes
VALUES
	(69299, 'Colombier-Saugnieu', 246900575);

INSERT INTO
	villes
VALUES
	(33281, 'M├®rignac', 243300316);

INSERT INTO
	villes
VALUES
	(46127, 'Gourdon', 244600482);

INSERT INTO
	villes
VALUES
	(12145, 'Millau', 241200567);

INSERT INTO
	villes
VALUES
	(26198, 'Mont├®limar', 200040459);

INSERT INTO
	villes
VALUES
	(5046, 'Embrun', 200067742);

INSERT INTO
	villes
VALUES
	(40192, 'Mont-de-Marsan', 244000808);

INSERT INTO
	villes
VALUES
	(65284, 'Louey', 200069300);

INSERT INTO
	villes
VALUES
	(9289, 'Lorp-Sentaraille', 200067940);

INSERT INTO
	villes
VALUES
	(31069, 'Blagnac', 243100518);

INSERT INTO
	villes
VALUES
	(34154, 'Mauguio', 243400470);

INSERT INTO
	villes
VALUES
	(13054, 'Marignane', 200054807);

INSERT INTO
	villes
VALUES
	(83153, 'Saint-Mandrier-sur-Mer', 248300543);

INSERT INTO
	villes
VALUES
	(6088, 'Nice', 200030195);

INSERT INTO
	villes
VALUES
	(66136, 'Perpignan', 200027183);

INSERT INTO
	villes
VALUES
	('2a004', 'Ajaccio', 242010056);

INSERT INTO
	villes
VALUES
	('2b148', 'Lucciana', 200036499);

INSERT INTO
	villes
VALUES
	(97418, 'Sainte-Marie', 249740119);

INSERT INTO
	villes
VALUES
	(97615, 'Pamandzi', 200050532);

INSERT INTO
	villes
VALUES
	(97110, 'La D├®sirade', 200041507);

INSERT INTO
	villes
VALUES
	(97101, 'Les Abymes', 200018653);

INSERT INTO
	villes
VALUES
	(97230, 'La Trinit├®', 200041788);

INSERT INTO
	villes
VALUES
	(97213, 'Le Lamentin', 249720061);

INSERT INTO
	villes
VALUES
	(97311, 'Saint-Laurent-du-Maroni', 249730037);

INSERT INTO
	villes
VALUES
	(97307, 'Matoury', 249730045);

INSERT INTO
	villes
VALUES
	(97308, 'Saint-Georges', 249730052);

INSERT INTO
	villes
VALUES
	(97353, 'Maripasoula', 249730037);

CREATE TABLE
	stations (
		id INTEGER,
		name TEXT NOT NULL,
		latitude INTEGER,
		longitude INTEGER,
		ville_id INTEGER,
		FOREIGN KEY (ville_id) REFERENCES villes (id)
	);

INSERT INTO
	stations
VALUES
	(
		7005,
		'ABBEVILLE',
		50.13600000000000278,
		1.834000000000000074,
		80001
	);

INSERT INTO
	stations
VALUES
	(
		7015,
		'LILLE-LESQUIN',
		50.57000000000000028,
		3.097500000000000142,
		59256
	);

INSERT INTO
	stations
VALUES
	(
		7020,
		'PTE DE LA HAGUE',
		49.72516699999999901,
		-1.939832999999999919,
		50041
	);

INSERT INTO
	stations
VALUES
	(
		7027,
		'CAEN-CARPIQUET',
		49.17999999999999972,
		-0.4561669999999999892,
		14137
	);

INSERT INTO
	stations
VALUES
	(
		7037,
		'ROUEN-BOOS',
		49.38300000000000267,
		1.181667000000000022,
		76116
	);

INSERT INTO
	stations
VALUES
	(
		7072,
		'REIMS-PRUNAY',
		49.20966700000000315,
		4.155332999999999721,
		51449
	);

INSERT INTO
	stations
VALUES
	(
		7110,
		'BREST-GUIPAVAS',
		48.4441670000000002,
		-4.411999999999999922,
		29075
	);

INSERT INTO
	stations
VALUES
	(
		7117,
		'PLOUMANAC''H',
		48.82583300000000292,
		-3.473167000000000115,
		22168
	);

INSERT INTO
	stations
VALUES
	(
		7130,
		'RENNES-ST JACQUES',
		48.06883299999999793,
		-1.733999999999999986,
		35281
	);

INSERT INTO
	stations
VALUES
	(
		7139,
		'ALENCON',
		48.44550000000000267,
		0.110167000000000001,
		61077
	);

INSERT INTO
	stations
VALUES
	(
		7149,
		'ORLY',
		48.71683300000000116,
		2.384332999999999814,
		91027
	);

INSERT INTO
	stations
VALUES
	(
		7168,
		'TROYES-BARBEREY',
		48.32466699999999805,
		4.019999999999999573,
		10030
	);

INSERT INTO
	stations
VALUES
	(
		7181,
		'NANCY-OCHEY',
		48.58100000000000306,
		5.959832999999999715,
		54523
	);

INSERT INTO
	stations
VALUES
	(
		7190,
		'STRASBOURG-ENTZHEIM',
		48.54950000000000187,
		7.640333000000000041,
		67212
	);

INSERT INTO
	stations
VALUES
	(
		7207,
		'BELLE ILE-LE TALUT',
		47.29433300000000173,
		-3.218332999999999889,
		56009
	);

INSERT INTO
	stations
VALUES
	(
		7222,
		'NANTES-BOUGUENAIS',
		47.14999999999999858,
		-1.608832999999999958,
		44150
	);

INSERT INTO
	stations
VALUES
	(
		7240,
		'TOURS',
		47.4444999999999979,
		0.7273330000000000072,
		37179
	);

INSERT INTO
	stations
VALUES
	(
		7255,
		'BOURGES',
		47.05916700000000219,
		2.359833000000000069,
		18033
	);

INSERT INTO
	stations
VALUES
	(
		7280,
		'DIJON-LONGVIC',
		47.26783300000000309,
		5.088333000000000438,
		21473
	);

INSERT INTO
	stations
VALUES
	(
		7299,
		'BALE-MULHOUSE',
		47.61433300000000201,
		7.509999999999999787,
		68042
	);

INSERT INTO
	stations
VALUES
	(
		7314,
		'PTE DE CHASSIRON',
		46.04683299999999946,
		-1.411499999999999977,
		17323
	);

INSERT INTO
	stations
VALUES
	(
		7335,
		'POITIERS-BIARD',
		46.59383299999999651,
		0.3143329999999999735,
		86194
	);

INSERT INTO
	stations
VALUES
	(
		7434,
		'LIMOGES-BELLEGARDE',
		45.86116700000000179,
		1.175000000000000044,
		87085
	);

INSERT INTO
	stations
VALUES
	(
		7460,
		'CLERMONT-FD',
		45.78683300000000144,
		3.149332999999999939,
		63113
	);

INSERT INTO
	stations
VALUES
	(
		7471,
		'LE PUY-LOUDES',
		45.07450000000000045,
		3.764000000000000234,
		43062
	);

INSERT INTO
	stations
VALUES
	(
		7481,
		'LYON-ST EXUPERY',
		45.72650000000000147,
		5.077833000000000041,
		69299
	);

INSERT INTO
	stations
VALUES
	(
		7510,
		'BORDEAUX-MERIGNAC',
		44.83066699999999827,
		-0.6913329999999999754,
		33281
	);

INSERT INTO
	stations
VALUES
	(
		7535,
		'GOURDON',
		44.74499999999999745,
		1.396666999999998992,
		46127
	);

INSERT INTO
	stations
VALUES
	(
		7558,
		'MILLAU',
		44.11849999999999738,
		3.019499999999999851,
		12145
	);

INSERT INTO
	stations
VALUES
	(
		7577,
		'MONTELIMAR',
		44.58116700000000065,
		4.732999999999999652,
		26198
	);

INSERT INTO
	stations
VALUES
	(
		7591,
		'EMBRUN',
		44.5656669999999977,
		6.50233300000000014,
		5046
	);

INSERT INTO
	stations
VALUES
	(
		7607,
		'MONT-DE-MARSAN',
		43.90983299999999901,
		-0.5001670000000000282,
		40192
	);

INSERT INTO
	stations
VALUES
	(
		7621,
		'TARBES-OSSUN',
		43.18800000000000238,
		0,
		65284
	);

INSERT INTO
	stations
VALUES
	(
		7627,
		'ST GIRONS',
		43.00533300000000025,
		1.106832999999999956,
		9289
	);

INSERT INTO
	stations
VALUES
	(
		7630,
		'TOULOUSE-BLAGNAC',
		43.62100000000000221,
		1.378832999999999976,
		31069
	);

INSERT INTO
	stations
VALUES
	(
		7643,
		'MONTPELLIER',
		43.57699999999999819,
		3.963166999999999885,
		34154
	);

INSERT INTO
	stations
VALUES
	(
		7650,
		'MARIGNANE',
		43.43766699999999759,
		5.216000000000000191,
		13054
	);

INSERT INTO
	stations
VALUES
	(
		7661,
		'CAP CEPET',
		43.07933299999999833,
		5.940832999999999587,
		83153
	);

INSERT INTO
	stations
VALUES
	(
		7690,
		'NICE',
		43.64883300000000333,
		7.208999999999999631,
		6088
	);

INSERT INTO
	stations
VALUES
	(
		7747,
		'PERPIGNAN',
		42.73716699999999947,
		2.87283299999999997,
		66136
	);

INSERT INTO
	stations
VALUES
	(
		7761,
		'AJACCIO',
		41.91799999999999927,
		8.792666999999999789,
		'2a004'
	);

INSERT INTO
	stations
VALUES
	(
		7790,
		'BASTIA',
		42.54066699999999913,
		9.48516700000000057,
		'2b148'
	);

INSERT INTO
	stations
VALUES
	(
		61968,
		'GLORIEUSES',
		-11.58266700000000071,
		47.28966700000000145,
		NULL
	);

INSERT INTO
	stations
VALUES
	(
		61970,
		'JUAN DE NOVA',
		-17.05466699999999846,
		42.7120000000000033,
		NULL
	);

INSERT INTO
	stations
VALUES
	(
		61972,
		'EUROPA',
		-22.34416699999999878,
		40.34066700000000339,
		NULL
	);

INSERT INTO
	stations
VALUES
	(
		61976,
		'TROMELIN',
		-15.88766700000000042,
		54.52066700000000309,
		NULL
	);

INSERT INTO
	stations
VALUES
	(
		61980,
		'GILLOT-AEROPORT',
		-20.89249999999999829,
		55.52866699999999867,
		97418
	);

INSERT INTO
	stations
VALUES
	(
		61996,
		'NOUVELLE AMSTERDAM',
		-37.7951669999999993,
		77.56916699999999309,
		NULL
	);

INSERT INTO
	stations
VALUES
	(
		61997,
		'CROZET',
		-46.43249999999999745,
		51.85666700000000162,
		NULL
	);

INSERT INTO
	stations
VALUES
	(
		61998,
		'KERGUELEN',
		-49.35233300000000156,
		70.24333300000000691,
		NULL
	);

INSERT INTO
	stations
VALUES
	(
		67005,
		'PAMANDZI',
		-12.80550000000000032,
		45.28283299999999655,
		97615
	);

INSERT INTO
	stations
VALUES
	(
		71805,
		'ST-PIERRE',
		46.76633300000000303,
		-56.17916699999999964,
		NULL
	);

INSERT INTO
	stations
VALUES
	(
		78890,
		'LA DESIRADE METEO',
		16.33500000000000085,
		-61.00399999999999779,
		97110
	);

INSERT INTO
	stations
VALUES
	(
		78894,
		'ST-BARTHELEMY METEO',
		17.90149999999999863,
		-62.85216700000000145,
		NULL
	);

INSERT INTO
	stations
VALUES
	(
		78897,
		'LE RAIZET AERO',
		16.26399999999999935,
		-61.51633300000000303,
		97101
	);

INSERT INTO
	stations
VALUES
	(
		78922,
		'TRINITE-CARAVEL',
		14.77449999999999975,
		-60.8753329999999977,
		97230
	);

INSERT INTO
	stations
VALUES
	(
		78925,
		'LAMENTIN-AERO',
		14.59533300000000011,
		-60.99566699999999742,
		97213
	);

INSERT INTO
	stations
VALUES
	(
		81401,
		'SAINT LAURENT',
		5.485500000000000042,
		-54.03166699999999878,
		97311
	);

INSERT INTO
	stations
VALUES
	(
		81405,
		'CAYENNE-MATOURY',
		4.822333000000000424,
		-52.36533299999999969,
		97307
	);

INSERT INTO
	stations
VALUES
	(
		81408,
		'SAINT GEORGES',
		3.890667000000000097,
		-51.80466700000000201,
		97308
	);

INSERT INTO
	stations
VALUES
	(
		81415,
		'MARIPASOULA',
		3.640166999999999931,
		-54.02833300000000349,
		97353
	);

INSERT INTO
	stations
VALUES
	(
		89642,
		'DUMONT D''URVILLE',
		-66.66316700000000139,
		140.0010000000000047,
		NULL
	);

CREATE TABLE
	utilisateur (
		utilisateur_id INTEGER PRIMARY KEY AUTOINCREMENT,
		utilisateur_pseudo TEXT NOT NULL,
		utilisateur_mdp TEXT NOT NULL,
		utilisateur_mail TEXT NOT NULL UNIQUE, -- L'email doit ├¬tre unique
		utilisateur_amis TEXT,
		created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
	);

INSERT INTO
	sqlite_sequence
VALUES
	('regions', 104);

COMMIT;