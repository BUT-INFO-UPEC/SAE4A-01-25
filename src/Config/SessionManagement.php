<?php

namespace Src\Config;

use Src\Model\DataObject\Dashboard;
use Src\Model\DataObject\Utilisateur;

class SessionManagement
{
	/** Return the curent loged user or null if not found
	 * 
	 * @return Utilisateur|null
	 */
	public static function getUser(): ?Utilisateur
	{
		return$_SESSION["user"] ?? null;
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

	public static function setDash(Dashboard $dashboard):void {
		$_SESSION["dash"] = $dashboard;
		$_SESSION["componants_to_delete"] = [];
	}

	public static function &get_curent_log_instance(): LogInstance {
		return $_SESSION['MSGs']["undying"][array_key_last($_SESSION['MSGs']["undying"])];
	}
}
