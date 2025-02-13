<?php

namespace Src\Config;

use Src\Config\Msg;

class MsgRepository
{
	const NO_REDIRECT = "none";
	const LAST_PAGE = "last";

	public static function newSuccess(string $success, string $message = "", string $redirection = MsgRepository::LAST_PAGE)
	{
		$_SESSION['MSGs']["list_messages"][] = new Msg("success", $success, $message);
		MsgRepository::redirect($redirection);
	}
	public static function newError(string $error, string $message = "", string $redirection = MsgRepository::LAST_PAGE)
	{
		$_SESSION['MSGs']["list_messages"][] = new Msg("danger", $error, $message);
		MsgRepository::redirect($redirection);
	}
	public static function newWarning(string $warning, string $message = "", string $redirection = MsgRepository::LAST_PAGE)
	{
		$_SESSION['MSGs']["list_messages"][] = new Msg("warning", $warning, $message);
		MsgRepository::redirect($redirection);
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
	static public function redirect($redirection): void
	{
		if ($redirection != MsgRepository::NO_REDIRECT) {
			$redirectUrl = $redirection != MsgRepository::LAST_PAGE ? $redirection : '?contorller=ControllerGeneral&action=home';
			header('Location: ' . $redirectUrl);

			unset($redirection);
			exit;
		} else return;
	}
}
