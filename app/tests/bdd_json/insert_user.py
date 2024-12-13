# insert_user.py

import json
import sqlite3
import os

# Chemin vers les fichiers JSON
structure_file_path = r"TESTS\bdd_json\structure.json"
insert_file_path = r"TESTS\bdd_json\integrer_user.json"

# Connexion à la base de données SQLite
db_file_path = r"TESTS\bdd_json\database.db"
connection = sqlite3.connect(db_file_path)
cursor = connection.cursor()

# Création des tables et des triggers à partir du fichier structure.json
with open(structure_file_path, 'r') as structure_file:
    structure_data = json.load(structure_file)

for table in structure_data['tables']:
    table_name = table['table_name']
    columns_definitions = ', '.join(
        f"{col['name']} {col['type']} {col['constraints']}" for col in table['columns']
    )
    create_table_query = f"CREATE TABLE IF NOT EXISTS {
        table_name} ({columns_definitions});"
    cursor.execute(create_table_query)

    # Création des triggers si définis
    for trigger in table.get('triggers', []):
        create_trigger_query = f"""
        CREATE TRIGGER IF NOT EXISTS {trigger['name']}
        {trigger['timing']} {trigger['event']} ON {table_name}
        {trigger['statement']}
        """
        cursor.execute(create_trigger_query)

# Validation des changements
connection.commit()

# Insertion des données à partir du fichier integrer_user.json
with open(insert_file_path, 'r') as insert_file:
    insert_data = json.load(insert_file)

# Récupération des informations pour l'insertion
table_name = insert_data['table_name']
columns = insert_data['insert']['columns']
values = insert_data['insert']['values']

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


