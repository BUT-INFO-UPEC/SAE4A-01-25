Le dossier 'assets' conteint les ressources du site, il est accéssible par internet.

Le dossier 'src' contient la logique du site, il n'est pas accésible directement.

Le dossier 'web' contient la porte d'entrée au site, il est accéssible par internet.

Le fichier 'index.php' sert de redirection vers le routeur principal pour automatiser l'entrée au site.


Le chargement d'une page web se fait de la manière suivante:

ENTRÉE => Le fichier web/FrontController.php est une porte d'entrée au site et il se charge d'initialiser les cookies et la session ainsi que de déterminer et appeler le controleur et son action demandé

LOGIQUE => Les controleurs du dossier src/Controller appelent les constructeurs du dossier src/Model/Repository qui eux initialisent des classes de src/Model/DataObject pour donner des instances d'objets métiers. Une fois les objets instanciers selon des paramètres GET ou POST, ils sont manipulés toujours dans leurs fichiers controlleur pour réaliser l'action delmandée.

VISUALISATION => Une fois les objets instanciés et manipulés, ils sont mis dans des variables, les controleurs définissent le visuel a charger et leur passent ces variables (qui sont mes objets manipulés) en paramètre. Les visualisations utilisent des noms de variables spécifique pour afficher dynamiquement le contenu.