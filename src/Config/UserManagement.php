<?php

namespace Src\Config;

use Src\Model\DataObject\Utilisateur;

class UserManagement
{
	public static function getUser(): ?Utilisateur
	{
		if (isset($_SESSION["user"])) return $_SESSION["user"];
		else return null;
	}
}
