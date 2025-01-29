<?php

namespace Src\Config;

use Src\Model\DataObject\Utilisateur;

class UserManagement
{
	public static function getUser(): ?Utilisateur
	{
		return isset($_SESSION["user"]) ? $_SESSION["user"] : null;
	}
}
