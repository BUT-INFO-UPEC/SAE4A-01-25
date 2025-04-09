<?php

namespace Src\Config\Utils;

use SessionHandler;
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
		return $_SESSION["user"] ?? null;
	}

	/** Return the curent loged user or null if not found
	 * 
	 * @return Utilisateur|null
	 */
	public static function getLogedId(): ?int
	{
		if (isset($_SESSION['user'])) {
			return $_SESSION["user"]->getId();
		} else return null;
	}

	/** Check if a user is logged in. Redirect with an error if not.
	 * 
	 * @return void
	 */
	public static function checkLogin(): void
	{
		if (!isset($_SESSION['user'])) {
			MsgRepository::newError("Vous devez être connecté pour effectuer cette action.", "Not loged in");
		}
	}

	public static function setDash(Dashboard $dashboard): void
	{
		$_SESSION["dash"] = $dashboard;
		$_SESSION["componants_to_delete"] = [];
	}

	public static function New_log_session() {
		SessionManagement::get_curent_log_instance()->new_DB_log("Nouvelle session : " . date("Y-m-d G:i:s", time()), "\n-----\n");
	}

	public static function &get_curent_log_instance(): LogInstance
	{
		return $_SESSION['MSGs']["undying"][array_key_last($_SESSION['MSGs']["undying"])];
	}
}
