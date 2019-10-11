<?php

namespace App\Http\Controllers;

class MessageParser{
	private $sender;

	private $message;

	public function __construct($message)
	{

	}

	public function getSender(){
		return $this->sender;
	}

	public function getMessage(){
		$return $this->message;
	}
}