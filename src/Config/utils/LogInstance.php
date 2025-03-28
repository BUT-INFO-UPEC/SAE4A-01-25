<?php

namespace Src\Config\Utils;

class LogInstance
{
	public const GREY = "bg-secondary";
	public const GREEN = "bg-success";
	public const BLUE = "bg-info";
	public const LIGHT = "bg-light";
	public const IMPORTANT = "bg-primary";

	#region attributs
	// =======================
	//        ATTRIBUTES
	// =======================
	/**
	 * $t=time();
	 * echo($t . "<br>");
	 * echo(date("Y-m-d",$t));
	 */
	private int $timestamp;
	private array $MsgList;
	private array $LogList;
	private string $called_action;
	private string $redirection;
	#endregion attributs

	// =======================
	//      CONSTRUCTOR
	// =======================
	public function __construct(string $action)
	{
		$this->timestamp = time();
		$this->called_action = $action;
	}

	#region Getters
	// =======================
	//      GETTERS
	// =======================
	function get_Timestamp(): string
	{
		return date("Y-m-d G:i:s", $this->timestamp);
	}
	function get_Called_Action(): string
	{
		return $this->called_action;
	}
	function get_Redirection(): string
	{
		return "Redirigé : " . ($this->redirection ?? "Aucune rediréction.");
	}
	function get_Msgs(): array
	{
		return $this->MsgList ?? [];
	}
	function get_Logs(): array
	{
		return $this->LogList ?? [];
	}
	#endregion Getters

	#region Stters
	// =======================
	//      SETTERS
	// =======================
	function set_redirection(string $redir): void
	{
		$this->redirection = $redir;
	}
	#endregion Stters

	#region public
	// =======================
	//    PUBLIC METHODS
	// =======================
	function add_Msg(Msg $message): void
	{
		$this->MsgList[] = $message;
	}
	function add_Msgs(array $messages): void
	{
		foreach ($messages as $message) {
			$this->add_Msg($message);
		}
	}
	function add_Log(string $message, $color = LogInstance::IMPORTANT): void
	{
		$this->LogList[] = [$color, $message];
	}
	function new_log(string $message, $color = "")
	{
		$this->add_Log(Utils::get_calling_class() . " : " . $message, $color); // ajouter le log avec la classe l'ayant initialiser en entete
	}

	function new_DB_log(string $message, $color = LogInstance::GREY){
		$this->add_log("Database action : " . $message, $color);

		// Le chemin vers le fichier
		$fichier = __DIR__ . '/../../../database/databaseUpdates.log';
		// Enlever les EOL (saut de ligne ou retour chariot)
		$contenuNettoye = str_replace(["\r\n", "\n", "\r"], " ", $message) ."\n";
		// Ajouter du texte à la fin du fichier
		file_put_contents($fichier, $contenuNettoye, FILE_APPEND);
		MsgRepository::Debug($message);
	}
	#endregion public
}
