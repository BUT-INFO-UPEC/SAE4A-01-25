<?php
use Src\Model\Repository\UtilisateurRepository;
use Src\Model\DataObject\Utilisateur;

//INSERT Adoption center
(new UtilisateurRepository)->insertUser(new Utilisateur('Adoption center', 'unclaimed.children@meteoscope.fr', 'garbage', 'collector', null, null), 'vitrygtr');