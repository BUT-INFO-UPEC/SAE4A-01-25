import json
import sqlite3
import os

# Chemin vers le fichier JSON
json_file_path = r"C:\WAMP64\WWW\SAE\TESTS\bdd_json\integrer_user.json"

# Connexion à la base de données SQLite
db_file_path = r"C:\WAMP64\WWW\SAE\TESTS\bdd_json\database.db"

# Connexion à la base de données
connection = sqlite3.connect(db_file_path)
cursor = connection.cursor()

# Lecture du fichier JSON
with open(json_file_path, 'r') as json_file:
    data = json.load(json_file)

# Extraction des colonnes et des valeurs
table_name = data['table_name']
columns = data['insert']['columns']
values = data['insert']['values']

# Préparation de la requête d'insertion avec IGNORE pour éviter les doublons
columns_str = ', '.join(columns)
placeholders = ', '.join(['?' for _ in columns])
insert_query = f'INSERT OR IGNORE INTO {
    table_name} ({columns_str}) VALUES ({placeholders})'

# Insertion des valeurs dans la base de données
for value in values:
    cursor.execute(insert_query, value)

    # Vérifiez si l'insertion a réussi
    if cursor.rowcount == 0:  # Cela signifie qu'aucune ligne n'a été insérée
        print(f"Erreur : Les données {
              value} existent déjà dans la table {table_name}.")

# Validation des changements
connection.commit()

# Fermeture de la connexion
cursor.close()
connection.close()
