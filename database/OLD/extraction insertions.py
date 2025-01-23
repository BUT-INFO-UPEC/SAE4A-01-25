import json

def json_to_sql_multi(files_with_mappings):
    """
    Convertit plusieurs fichiers JSON en commandes SQL d'insertion pour plusieurs tables.

    :param files_with_mappings: Liste de dictionnaires, chaque dict contenant :
        - 'json_file': Chemin vers le fichier JSON.
        - 'table_name': Nom de la table SQL.
        - 'column_mapping': Dictionnaire pour mapper les clés JSON aux colonnes SQL.
    :return: Commandes SQL d'insertion sous forme de chaîne.
    """
    sql_commands = []

    for file_info in files_with_mappings:
        json_file = file_info['json_file']
        table_name = file_info['table_name']
        column_mapping = file_info['column_mapping']

        with open(json_file, 'r', encoding='utf-8') as file:
            data = json.load(file)

        if not isinstance(data, list):
            data = [data]

        for entry in data:
            columns = ', '.join(column_mapping.values())  # Utilise les colonnes SQL
            values = ', '.join(
                f"'{str(entry.get(json_key, '')).replace('\'', '\'\'')}'" if entry.get(json_key) is not None else 'NULL'
                for json_key in column_mapping.keys()
            )
            sql_command = f"INSERT INTO {table_name} ({columns}) VALUES ({values});"
            sql_commands.append(sql_command)

    return "\n".join(sql_commands)

# Exemple d'utilisation
files_with_mappings = [
    {
        "json_file": "dashboards.json",
        "table_name": "Dashboards",
        "column_mapping": {
            "dashboard_id": "id",
            "createur_id": "createur_id",
            "date_debut": "date_debut",
            "date_fin": "date_fin",
            "date_debut_relatif": "date_debut_relatif",
            "date_fin_relatif": "date_fin_relatif",
            "param": "params"
        }
    },
    {
        "json_file": "Composants.json",
        "table_name": "Composants",
        "column_mapping": {
            "composant_id": "id",
            "repr_type": "repr_type",
            "attribut": "attribut",
            "aggregation": "aggregation",
            "param_affich": "params_affich"
        }
    },
    {
        "json_file": "Attributs.json",
        "table_name": "Attributs",
        "column_mapping": {
            "value_type": "value_type",
            "key": "key",
            "name": "name",
            "example": "example",
            "unit": "unit",
            "description": "description"
        }
    },
    {
        "json_file": "Groupings.json",
        "table_name": "Grouppings",
        "column_mapping": {
            "nom": "nom",
            "type": "type",
            "cle": "cle"
        }
    },
    {
        "json_file": "Representations.json",
        "table_name": "Representations",
        "column_mapping": {
            "name": "name",
            "poss_groupping": "poss_groupping",
            "visualisation_constructor": "visu_fichier"
        }
    }
]

sql = json_to_sql_multi(files_with_mappings)

# Sauvegarder dans un fichier SQL
with open("output.sql", "w", encoding="utf-8") as output_file:
    output_file.write(sql)

print("Les commandes SQL ont été générées et sauvegardées dans 'output.sql'.")
