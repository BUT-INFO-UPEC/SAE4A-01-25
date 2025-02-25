<?php

namespace Src\Config;

class CookiesConf
{
 /** Crée un cookie sur l
	* 
	* Durée des cookies (7 jours)
	* 
  * @param string $cokie_name Le nom de référence du cookie
  * @param mixed $cookie_value La valeur a attrituer a la reférence pour etre enregistrée dans le cookie
  * 
  * @return void
  */
	public static function setCookie(string $cokie_name, $cookie_value): void
	{
		// Allocation de la valeur cotés client
		setcookie(
			$cokie_name,
			$cookie_value,
			time() + (3600 * 24 * 7),
			"/",
		);

		// Alocation locale pour utilisation imédiate
		$_COOKIE[$cokie_name] = $cookie_value;
	}

	/** Supprime un cookie en réglant sa date d'expiration dans le passé
	 * 
	 * @param string $cookie_name Le nom de référence du cookie
	 * 
	 * @return void
	 */
	public static function unSetCookie(string $cookie_name): void
	{
		// Suppression du cookie côté client en réglant une expiration passée
		setcookie(
			$cookie_name,
			"",
			time() - 1,
			"/"
		);

		// Suppression de la valeur du tableau $_COOKIE côté serveur
		unset($_COOKIE[$cookie_name]);
	}
}
