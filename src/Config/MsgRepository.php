<?php

namespace Src\Config;

use Src\Config\Msg;

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

	/** Create a new message of type error
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
			header('Location: ' . $redirectUrl);
		}
	}
}
