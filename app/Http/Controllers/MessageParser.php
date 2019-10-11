<?php

namespace App\Http\Controllers;

class MessageParser{
	private $sender;

	private $message;

	public function __construct($message)
	{
		$this->message = $message['data'];
	}

	public function getSender()
	{
		return $this->message['contact_id'];
	}

	public function getMessage()
	{
		return $this->message['body'];
	}
}