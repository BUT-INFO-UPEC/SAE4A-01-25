Le dossier 'controller' contient le routage et les actions composant la logique du site internet, il actionne les fonctionnalités du model et redirige vers les vues appropriées.

Les controleurs sont divisés en trois parties:
-Les actions d'entrée qui sont accéssibes sans prérequis et permettent d'accéder a des formulaires et autres informations directionnels.
-Les actions d'accés sont les actions disponible a l'utilisateur si il sait ce qu'il cherche (en replissant un formulaire get).
-Les actions de retour sont des actions internes au site qui renvoient l'utilisateur vers des pages d'entrée ou d'accés aprés avoir réaliser des modification sur les données du site en retour a un formulaire.