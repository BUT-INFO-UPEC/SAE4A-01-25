<?php

namespace Src\Model\DataObject;

/**
 * Utility class for managing session messages.
 */
class Msg
{
	/**
	 * Class or type of the message.
	 * 
	 * @var string
	 */
	private string $error_type;
	/**
	 * Error name or code.
	 * 
	 * @var string
	 */
	private string $header;
	/**
	 * Message content (operation description).
	 * 
	 * @var string 
	 */
	private string $message;

	/**
	 * Constructor.
	 *
	 * @param string $msg The message to set.
	 */
	public function __construct(string $error_type, string $header, string $message)
	{
		$this->error_type = $error_type;
		$this->header = $header;
		$this->message = $message;
	}

	public function getType(): string
	{
		return $this->error_type;
	}
	public function getError(): string
	{
		return $this->header;
	}
	public function getMessage(): string
	{
		return $this->message;
	}
}
