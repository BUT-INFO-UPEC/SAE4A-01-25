<?php

namespace Src\Config;

use Src\Model\DataObject\Utilisateur;

class UserManagement
{
	/** Return the curent loged user or null if not found
	 * 
	 * @return Utilisateur|null
	 */
	public static function getUser(): ?Utilisateur
	{
		return isset($_SESSION["user"]) ? $_SESSION["user"] : null;
	}

	/** Check if a user is logged in. Redirect with an error if not.
	 * 
	 * @return void
	 */
	public static function checkLogin(): void
	{
		if (!isset($_SESSION['login'])) {
			MsgRepository::newError("Vous devez être connecté pour effectuer cette action.", "Not loged in");
		}
	}

}
