<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use WA;
use MessageParser;

class RegisterController extends Controller
{
	private $allowedCommand = ['daftar', 'jadwal dokter'];

	private $wa;

	private $visitor = [];

	public function __construct(){
		$this->wa = new WA();
	}

    public function index(Request $request)
    {
    	$message = new MessageParser($request);

    	//Cek apakah ada sesi chat pendaftaran sesuai sender pada hari ini
    	$currentChatSession = ChatSession::where('sender', $message->getSender())
							    	->where('created_at', '>', Carbon::now()->startOfDay())
							    	->where('created_at', '<', Carbon::now()->endOfDay());

		/**
		 * Current Step
		 * new -> nama -> tempat lahir -> tanggal lahir -> jenis kelamin -> poli
		 * */

	 	if($currentChatSession->count() > 0){

	 		//Step pertama (nama)
	 		if($message->getMessage() == 'daftar' && $currentChatSession->get()->first()->last_step == 'new'){
	 			$currentChatSession->update(['last_step' => 'nama']);
	 			$this->wa->reply('Silakan masukan nama anda');
	 		}

	 		//Step kedua (tempat lahir)
	 		if($currentChatSession->get()->first()->last_step == 'nama'){
	 			$this->visitor['name'] = $message->getMessage();
	 			$currentChatSession->update(['last_step' => 'tempat_lahir']);
	 			$this->wa->reply('Silakan masukan tempat lahir anda');
	 		}

	 		//Step kedua (tanggal lahir)
	 		if($currentChatSession->get()->first()->last_step == 'tempat_lahir'){
	 			$this->visitor['place_of_birth'] = $message->getMessage();
	 			$currentChatSession->update(['last_step' => 'tanggal_lahir']);
	 			$this->wa->reply('Silakan masukan tanggal lahir anda');
	 		}

	 		//Step kedua (jenis kelamin)
	 		if($currentChatSession->get()->first()->last_step == 'tanggal_lahir'){
	 			$this->visitor['date_of_birth'] = $message->getMessage();
	 			$currentChatSession->update(['last_step' => 'jenis_kelamin']);
	 			$this->wa->reply('Silakan masukan jenis kelamin anda');
	 		}

	 		//Step kedua (poli)
	 		if($currentChatSession->get()->first()->last_step == 'jenis_kelamin'){
	 			$this->visitor['gender'] = $message->getMessage();
	 			$currentChatSession->update(['last_step' => 'poli']);
	 			$this->wa->reply('Silakan masukan pilihan poli anda');
	 		}

	 		//Step kedua (tempat lahir)
	 		if($currentChatSession->get()->first()->last_step == 'poli'){
	 			$this->visitor['poli'] = $message->getMessage();
	 			$currentChatSession->update(['last_step' => 'confirm']);
	 			$this->wa->reply('Silakan masukan tempat lahir anda');
	 		}

	 		//Step kedua (tempat lahir)
	 		if($currentChatSession->get()->first()->last_step == 'confirm'){	
	 			$visitor = new Visitor;
	 			$visitor->name = $this->visitor['name'];
	 			$visitor->place_of_birth = $this->visitor['place_of_birth'];
	 			$visitor->date_of_birth = $this->visitor['date_of_birth'];
	 			$visitor->gender = $this->visitor['gender'];
	 			$visitor->poli = $this->visitor['poli'];
	 			$visitor->save();

	 			$response = 'Berikut ini adalah detail pendaftaran anda: \n' . 
	 						"Nama : $this->visitor['name'] \n" .
	 						"Tempat Lahir : $this->visitor['place_of_birth'] \n" .
	 						"Tanggal Lahir : $this->visitor['date_of_birth'] \n" .
	 						"Jenis Kelamin : $this->visitor['gender'] \n" .
	 						"Poli : $this->visitor['poli'] \n" .
	 						"Anda mendapat nomor antrian ke - $queueNumber"
	 		}
	 	} else {
			if(!in_array($message->content, $allowedCommand)){
	    		$this->wa->reply('Pesan yang anda kirim tidak sesuai format. Anda dapat melakukan pendaftaran pasien dan cek jadwal dokter.')
	    	} else {
				//Simpan Chat Session jika belum ada sebelumnya
		 		$chatSession = new ChatSession;
		 		$chatSession->sender = $message->getSender();
		 		$chatSession->last_step = 'new';
		 		$chatSession->save();
	    	}
	 	}


    }
}
