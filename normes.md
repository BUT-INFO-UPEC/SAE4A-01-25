
# Structure de codes:
Le code est écrit sur des lignes infinies, sans retour a la ligne même quand la ligne fait des miliers de caractères a cause de la fonctionnalité de retour a la ligne automatique directement dans l'éditeur, le wordwrap.
Pour acitver/désactiver cette fonctionnalité sur VSCode, utilisez le racourcis "alt + z".

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
	#region Attributs
	// =======================
	//        ATTRIBUTES
	// =======================

	#endregion Attributs

	// =======================
	//      CONSTRUCTOR
	// =======================


	#region Getters
	// =======================
	//      GETTERS
	// =======================

	#endregion Getters


	#region Stters
	// =======================
	//      SETTERS
	// =======================

	#endregion Stters


	#region Publiques
	// =======================
	//    PUBLIC METHODS
	// =======================

	#endregion Publiques


	#region Privees
	// =======================
	//    PRIVATE METHODS
	// =======================

	#endregion Privees

	#region Statiques
	// =======================
	//    STATIC METHODS
	// =======================

	#endregion Statiques


	#region Abstracts
	// =======================
	//    ABSTRACTS
	// =======================

	#endregion Abstracts

	#region Protected
	// =======================
	//    PUBLIC PROTECTED
	// =======================

	#endregion Protected


	#region Overides
	// =======================
	//    OVERIDES
	// =======================

	#endregion Overides

}
```

## HTML

Mettre un saut de ligne entre des balises d'un même niveau

NomOuID

```html
<balise_parente>
	<balise_parente>
		<balise_sans_enfant> </balise_sans_enfant>

		<balise_sans_enfant> </balise_sans_enfant>
	</balise_parente>

	<balise_sans_enfant> </balise_sans_enfant>
	<balise_parente> </balise_parente>
</balise_parente>
```