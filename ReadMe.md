perso je ne ferais pas de retour a la ligne même quand la ligne fait des miliers de caractères car j'ai actionné le retour a la ligne en fin de page, dites moi ce que vous en pensez, si vous voulez acitver/désactiver cette fonctionnalité:
alt + z

---

- Acronymes et mots clé:
  Acronymes:

BDD = Base De Données

abréviations:

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

mots clés:

dashboard = tableau de bords
composant = composant du dashboard (la représentation de lanalyse d'une donnée (un atribut))
grouping = critère d'association des valeurs pour application de la fonction d'aggregation (jour, heure, mois, année, commune, ville)
aggregation = fonction analytique appliquée sun un tableau de données pour en tirer une valeur synthétique (min, max, moy)
fetch = récupération d'informations depuis la BDD
representation = mise en forme visuelle des données pour permettre leur comprehension (sous forme de graphique par exemple)

---

- Structure de codes:

## BDD

qqc_id = identifiant (primaire ou secondaire)
nom_attribut

noms des tables et ses attributs en francais ou mots clés, pluriel

## PHP - JAVASCRIPT

fonction_composed_of_multiple_words()
atributCompose2PlusieursMots
variableComposee2PlusieursMots
NomDeClassComposee (a éviter, le plus possible en un mot)

noms de fonction en anglais
noms de attributs/variables en francais ou mots clés
noms de classes en francais ou mots clés avec une majuscule au début
1 ligne vide entre les fonctions

penser a ajouter des docstring au dessu des fonctoins:

```php
/**
 * Résumé de la fonction.
 *
 * Description plus détaillée de la fonction, si nécessaire.
 *
 * liste(
 * @param type $nomAttribut Description
 * )
 * @return type Description
 */
function my_function() {}
```

structurer les classes java avec des commentaires:

```php
/**
 * Description de la classe
 */
class MyClass {
    // =======================
    //        ATTRIBUTES
    // =======================
    #region Attributs
    #endregion Attributs

    // =======================
    //      CONSTRUCTOR
    // =======================


    // =======================
    //      GETTERS
    // =======================
    #region Getters

    #endregion Getters


    // =======================
    //      SETTERS
    // =======================
    #region Stters

    #endregion Stters


    // =======================
    //    PUBLIC METHODS
    // =======================
    #region Publiques

    #endregion Publiques


    // =======================
    //    PRIVATE METHODS
    // =======================
    #region Privees

    #endregion Privees

    // =======================
    //    STATIC METHODS
    // =======================
    #region Statiques

    #endregion Statiques


    // =======================
    //    OVERIDES
    // =======================
    #region Overides

    #endregion Overides

}
```

## HTML

classes_composees2plusieurs_mots (ou pas en fonction de si l'on utilise des frameworks)
NomOuID

```html
<balise_parente>
  <balise_parente>
    <balise_sans_enfant> </balise_sans_enfant>

    <balise_sans_enfant> </balise_sans_enfant>
  </balise_parente>

  <balise_sans_enfant> </balise_sans_enfant>
  <balise_parente></balise_parente
></balise_parente>
```

- pas de saut de ligne entre la balise parente ouvrante et ses balises parente et 1er enfant (juste retour a la ligne et tabulation) mais entre les différentes balises enfants (maj+alt+F)
