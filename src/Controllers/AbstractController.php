<?php

namespace Src\Controllers;

abstract class AbstractController
{
	/**
	 * Méthode par défaut standardisée
	 * 
	 * @return void Redirige vers l'action par défaut du controleur
	 */
	abstract static function default(): void;
}
