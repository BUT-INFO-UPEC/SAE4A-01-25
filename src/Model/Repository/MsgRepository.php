<?php

namespace Src\Model\Repository;

use Src\Model\DataObject\Msg;

class MsgRepository
{
	public static function newSuccess(string $success, string $message = "", string $redirection = "last") {
		$_SESSION['MSGs']["list_messages"][] = new Msg("success", $success, $message, $redirection);
		MsgRepository::redirect();
	}
	public static function newError(string $error, string $message = "", string $redirection = "last") {
		$_SESSION['MSGs']["list_messages"][] = new Msg("danger", $error, $message, $redirection);
		MsgRepository::redirect();
	}
	public static function newWarning(string $warning, string $message = "", string $redirection = "last") {
		$_SESSION['MSGs']["list_messages"][] = new Msg("warning", $warning, $message, $redirection);
		MsgRepository::redirect();
	}

	/**
	 * Check if a user is logged in. Redirect with an error if not.
	 */
	public static function checkLogin(): void
	{
		if (!isset($_SESSION['login'])) {
			MsgRepository::newError("Vous devez être connecté pour effectuer cette action.", "Not loged in");
		}
	}

	/**
	 * Redirect to the previous page or a fallback home page.
	 */
	static public function redirect(): void
	{
		$redirectUrl = $_SESSION["MSGs"]["redirect"] != "last" ? $_SESSION["MSGs"]["redirect"] : $_SERVER['HTTP_REFERER'];
		header('Location: ' . $redirectUrl);

		unset($_SESSION["MSGs"]["redirect"]);
		exit;
	}
}