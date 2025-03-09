<?php

namespace Src\Config;

class LogInstance
{

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
		return $this->redirection ?? "Aucune rediréction.";
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
	function add_Msgs(Array $messages): void
	{
		foreach ($messages as $message) {
			$this->add_Msg($message);
		}
	}
	function add_Log(string $message): void
	{
		$this->LogList[] = $message;
	}
	#endregion public
}
