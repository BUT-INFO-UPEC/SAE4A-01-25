<?php

namespace Src\Config;

use Src\Config\Msg;

/** Create different kind of messages, instanciate them in a list and redirect
 */
class MsgRepository
{
	const NO_REDIRECT = "none";
	const LAST_PAGE = "last";

	/** Create a new message of type success
	 *
	 * @param string $success
	 * @param string $message
	 * @param string $redirection
	 *
	 * @return void
	 */
	public static function newSuccess(string $success, string $message = "", string $redirection = MsgRepository::LAST_PAGE): void
	{
		$_SESSION['MSGs']["list_messages"][] = new Msg(Msg::SUCCESS, $success, $message);
		MsgRepository::redirect($redirection);
	}

	/** Create a new message of type error
	 * 
	 * @param string $error
	 * @param string $message
	 * @param string $redirection
	 *
	 * @return void
	 */
	public static function newError(string $error, string $message = "", string $redirection = MsgRepository::LAST_PAGE): void
	{
		$_SESSION['MSGs']["list_messages"][] = new Msg(Msg::ERROR, $error, $message);
		MsgRepository::redirect($redirection);
	}

	/** Create a new message of type warning
	 * 
	 * @param string $warning
	 * @param string $message
	 * @param string $redirection
	 *
	 * @return void
	 */
	public static function newWarning(string $warning, string $message = "", string $redirection = MsgRepository::LAST_PAGE): void
	{
		$_SESSION['MSGs']["list_messages"][] = new Msg(Msg::WARNING, $warning, $message);
		MsgRepository::redirect($redirection);
	}

	/** Create a new message of type primary
	 * 
	 * @param string $title
	 * @param string $message
	 * @param string $redirection
	 * 
	 * @return void
	 */
	public static function newPrimary(string $title, string $message = "", string $redirection = MsgRepository::LAST_PAGE): void {
		$debugMsg = new Msg(Msg::PRIMARY, $title, $message);
		MsgRepository::redirect($redirection);
		$_SESSION["MSGs"]['list_messages'][] = $debugMsg;
		$_SESSION['MSGs']["undying"][] = $debugMsg;
	}

	/** Create a new message of type secondary wich is reserved for developpement puroses
	 * 
	 * @param mixed $var
	 * @return void
	 */
	public static function Debug(mixed $var): void {
		$_SESSION["MSGs"]['list_messages'][] = new Msg(Msg::SECONDARY, "debuging", var_export($var, true));
		MsgRepository::redirect(MsgRepository::NO_REDIRECT);
	}

 /** Redirect to a specified destination, the previous page or a fallback home page.
	*
  * @param mixed $redirection
  *
  * @return void
  */
	static public function redirect($redirection): void
	{
		if ($redirection != MsgRepository::NO_REDIRECT) {
			$redirectUrl = $redirection != MsgRepository::LAST_PAGE ? $redirection : '?action=default';

			//allimenter le log pour deboggage
			$_SESSION['MSGs']["undying"][] = [$_SESSION["MSGs"]['list_messages'], $redirectUrl];

			// rediriger vers la destination définie
			header('Location: ' . $redirectUrl);
		}
	}
}
