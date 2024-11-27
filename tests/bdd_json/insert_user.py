import MySQLdb
import json

# Chemin du fichier JSON (assurez-vous qu'il est au bon endroit ou utilisez un chemin absolu)
json_file = 'integrer_user.json'

try:
    with open(json_file, 'r') as f:
        data = json.load(f)
        # Affiche la valeur de "table_name"
        print("Nom de la table :", data['table_name'])
        # Vous pouvez aussi afficher les colonnes et les valeurs pour validation
        print("Colonnes :", data['insert']['columns'])
        print("Valeurs :", data['insert']['values'])

except FileNotFoundError:
    print(f"Erreur : le fichier {json_file} est introuvable.")
except json.JSONDecodeError as e:
    print(f"Erreur de décodage JSON : {e}")
except KeyError as e:
    print(f"Clé manquante dans le JSON : {e}")
