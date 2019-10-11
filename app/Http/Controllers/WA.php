<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;

use Log;

class WA
{
	protected $client;
	protected $url;
	function __construct()
	{
		$this->client = new Client([
			'headers' => [
			   'Content-Type' => 'application/json',
			   'X-Requested-With' => 'XMLHttpRequest'
			]
		 ]);
		 $this->url = 'https://bni.atoz.co.id/api';
	}	
	
	public function reply($to, $message)
	{
		try {
			$response = $this->client->request('POST', $this->url.'/send-text', [
				'body' => json_encode([
					'sender_id' => '628973709279',
					'contact_id' => $to,
					'body' => $message
				])
			]);
		} catch (\Exception $th) {
			Log::info(json_encode($th));
		}	
	}
}