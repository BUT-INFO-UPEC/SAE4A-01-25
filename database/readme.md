# Fichiers de construction et mise a jour de la base de donées

## Instanciation de la BDD
Le fichier "BD_init.sql" initialise la BDD dans un SGBD de type SQLITE.
Pour l'instancier dans 

Certains fichiers de ce dossier contiennent des instructions sql nécéssairent pour instancier la BDD et lancer l'application:
- "crea_tables.sql" : créer les tables
- "static_data.sql" : insérer les données les plus péraines (stations et hiérarchie géographique)
- "parameters_data.sql" : insérer les composants des fonctionnalités prises en compte par l'application et les paramètres de leur éxécution
- "insertion_data.sql" : insérer les jeux de données métiers pour pouvoir lancer l'application avec un minimum de contenu

## Solution de partage de données relative au versionnage
Le fichier "databaseUpdates.log" contient les opérations réalisées lors de l'utilisation de l'application en phase de test et de développement pour maintenir une continuité des données et ne pas perdre les données créées lors des phases de test.
Il est consitué des opérations réalisées lors de l'utilisation de l'application.

Le fichier "src/Config/ServerConf/db_manager.php" a pour role d'éxécuter les opérations recorées dans "database/Fixtures" qui ne sont pas déja implémentées sur la BDD locale.