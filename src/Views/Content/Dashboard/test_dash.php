<?php


use Src\Model\API\Constructeur_Requette_API;

$requete = new Constructeur_Requette_API(
	[
		't as temperatures'
	],
	[],  // 'where' doit être un tableau (vide ou rempli)
	[],  // 'group_by' doit être un tableau (vide ou rempli)
	'',  // 'order_by' est une chaîne de caractères
	2,  // 'limit' est un entier
	0,  // 'offset' doit être un entier (vous pouvez mettre 0 par défaut)
	[],  // 'refine' doit être un tableau (vide ou rempli)
	[],  // 'exclude' doit être un tableau (vide ou rempli)
	'fr',  // 'lang' est une chaîne de caractères (vous pouvez mettre 'fr' par défaut)
	'Europe/Paris'  // 'timezone' est une chaîne de caractères (vous pouvez mettre 'Europe/Paris' par défaut)
);

echo $requete->formatUrl();  // Cela retournera l'URL avec "order_by=date desc"

// https://public.opendatasoft.com/api/explore/v2.1/catalog/datasets/donnees-synop-essentielles-omm/records?select=t as temperature
