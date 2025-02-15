<?php

namespace Src\Config;

/**
 * Utility class for managing session messages.
 */
class Msg
{
	public const ERROR = "danger";
	public const WARNING = "danger";
	public const SUCCESS = "danger";

	private string $message_type;
	private string $header;
	private string $message;

	/**
	 * @param string $message_type Le type de message a afficher (succés, avertissement ou erreur)
	 * @param string $header
	 * @param string $message
	 */
	public function __construct(string $message_type, string $header, string $message)
	{
		$this->message_type = $message_type;
		$this->header = $header;
		$this->message = $message;
	}

	/** Get the type of the message
	 * 
	 * One of Msg constant : ERROR, WARNING or SUCCESS
	 * 
	 * @return string
	 */
	public function getType(): string
	{
		return $this->message_type;
	}
	/** Get the main title of the message
	 * 
	 * @return string
	 */
	public function getTitle(): string
	{
		return $this->header;
	}
	/** Get the compelementory description of the message
	 * 
	 * @return string
	 */
	public function getMessage(): string
	{
		return $this->message;
	}
}
