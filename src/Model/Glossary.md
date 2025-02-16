## Acronymes:
BDD = base de données

## abréviations:

qqc = quelque chose

qqn = quelqu'un

param = paramètre(s)

id = identifiant

pswd = password = mot de passe

repr = representation

data = donnée(s)

override = outrepasser les protocoles de sécurité

depts = departements

epcis = tructures administratives permettant à plusieurs communes d'exercer des compétences en commun

## mots clés:

dashboard = tableau de bords

composant = composant du dashboard (la représentation de lanalyse d'une donnée (un atribut))

grouping = critère d'association des valeurs pour application de la fonction d'aggregation (jour, heure, mois, année, commune, ville)

aggregation = fonction analytique appliquée sun un tableau de données pour en tirer une valeur synthétique (min, max, moy)

fetch = récupération d'informations depuis la BDD

representation = mise en forme visuelle des données pour permettre leur comprehension (sous forme de graphique par exemple)

---

Modèle =
Élément qui contient les données ainsi que de la logique en rapport avec les données : validation, lecture et enregistrement. Il peut, dans sa forme la plus simple, contenir uniquement une simple valeur, ou une structure de données plus complexe. Le modèle représente l'univers dans lequel s'inscrit l'application. Par exemple pour une application de banque, le modèle représente des comptes, des clients, ainsi que les opérations telles que dépôt et retraits, et vérifie que les retraits ne dépassent pas la limite de crédit.

Vue =
Partie visible d'une interface graphique. La vue se sert du modèle, et peut être un diagramme, un formulaire, des boutons, etc. Une vue contient des éléments visuels ainsi que la logique nécessaire pour afficher les données provenant du modèle. Dans une application de bureau classique, la vue obtient les données nécessaires à la présentation du modèle en posant des questions. Elle peut également mettre à jour le modèle en envoyant des messages appropriés. Dans une application web une vue contient des balises HTML.

Contrôleur =
Module qui traite les actions de l'utilisateur, modifie les données du modèle et de la vue.