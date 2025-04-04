INSERT INTO Dashboards (createur_id, immortalised_id, date_debut, date_fin, date_debut_relatif, date_fin_relatif, params) 
VALUES (0, 0, '0000-00-14', '0000-00-07', True, True, '{"title": "Dashboard initial"}');

INSERT INTO Saves (id, createur_id, date_debut, date_fin, date_debut_relatif, date_fin_relatif, params, components_save, geo_save) 
VALUES (0, 0, '0000-00-14', '0000-00-07', True, True, '{"title": "Dashboard initial"}', '[{"representation": "generate_text_representation.php", "attribut": "t", "aggregation":"avg","groupping": ""}]', '{"numer_sta": "78925"}');

INSERT INTO Analyses (repr_type, attribut, aggregation, groupping) 
VALUES (2, 1, 1, 3);

INSERT INTO Composants (dashboard_id, analysis_id, params_affich) 
VALUES (0 ,0, '{"titre":"coucou", "chartId":0}');

INSERT INTO CritereGeo_dashboard (dashboard_id, type_critere, critere_id) 
VALUES ( 0, 0, "78925");

INSERT INTO utilisateur (utilisateur_id,utilisateur_pseudo,utilisateur_mdp,utilisateur_mail,created_at,utilisateur_nom,utilisateur_prenom) 
VALUES (0,"DefaultUser","vitrygtr","admin@meteoscope.fr","0000-00-00 00:00:00","ADMINISTRATEUR","Deboggeur");
INSERT INTO utilisateur (utilisateur_pseudo,utilisateur_mdp,utilisateur_mail,utilisateur_amis,created_at,utilisateur_nom,utilisateur_prenom,utilisateur_nb_conn) 
VALUES
	('Kirito_140','max111005','maxence.campourcy@etu.u-pec.fr',NULL,'2025-01-23 11:55:58','Campourcy','Maxence',8),
	('JD','123','a@b.c',NULL,'2025-01-23 15:44:16','Doe','John',10),
	('Shadow','12345','amine.bouras33@gmail.com',NULL,'2025-01-24 09:49:19','Bouras','Mohamed Amine',0);
INSERT INTO utilisateur (utilisateur_pseudo,utilisateur_mdp,utilisateur_mail,utilisateur_amis,utilisateur_nom,utilisateur_prenom,utilisateur_nb_conn) 
VALUES
	('D','12345','dishabh10@gmail.com',NULL,'Bh','Dsh',0),
	('Lga','TestSAE2025','ahmed.sadoudi@etu.u-pec.fr',NULL,'Ahmed','Sadoudi',0);