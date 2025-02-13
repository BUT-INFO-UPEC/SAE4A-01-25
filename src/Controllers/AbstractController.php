<?php

namespace Src\Controllers;

abstract class AbstractController
{
	/** Retourne la methode/route par défaut pour ce contrôleur
	 * 
	 * @return void Redirige vers l'action par défaut du controleur
	 */
	abstract static function default(): void;
}
