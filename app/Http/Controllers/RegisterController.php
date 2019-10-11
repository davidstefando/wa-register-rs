<?php

namespace App\Http\Controllers;

use App\ChatSession;
use Illuminate\Http\Request;

use App\Http\Controllers\WA;
use App\Http\Controllers\MessageParser;

use Carbon\Carbon;
use App\Visitor;


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
		if($request['type'] == 'message') {
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
				$chatSession = $currentChatSession->get()->first();

				//Step pertama (nama)
				if(strtolower($message->getMessage()) == 'daftar' && $currentChatSession->get()->first()->last_step == 'new'){
					$currentChatSession->update(['last_step' => 'nama']);
					$this->wa->reply($message->getSender(), 'Silakan masukan nama anda');
					return response()->json(['message' => 'success'], 200);
				} else {
					return $this->wa->reply($message->getSender(), 'Pesan yang anda kirim tidak sesuai format. Anda dapat melakukan pendaftaran pasien, balas pesan ini dengan kata "Daftar"');
				}

				//Step kedua (tempat lahir)
				if($currentChatSession->get()->first()->last_step == 'nama'){
					$visitor = Visitor::firstOrNew([
						'chat_session_id' => $chatSession->id
					]);
					$visitor->name = $message->getMessage();
					$visitor->save();

					$currentChatSession->update(['last_step' => 'tempat_lahir']);
					$this->wa->reply($message->getSender(), 'Silakan masukan tempat lahir anda');
					return response()->json(['message' => 'success'], 200);
				}

				//Step ketiga (tanggal lahir)
				if($currentChatSession->get()->first()->last_step == 'tempat_lahir'){
					$visitor = Visitor::firstOrNew([
						'chat_session_id' => $chatSession->id
					]);
					$visitor->place_of_birth = $message->getMessage();
					$visitor->save();
					
					$currentChatSession->update(['last_step' => 'tanggal_lahir']);
					$this->wa->reply($message->getSender(), 'Silakan masukan tanggal lahir anda');
					return response()->json(['message' => 'success'], 200);
				}

				//Step keempat (jenis kelamin)
				if($currentChatSession->get()->first()->last_step == 'tanggal_lahir'){
					$visitor = Visitor::firstOrNew([
						'chat_session_id' => $chatSession->id
					]);
					$visitor->date_of_birth = $message->getMessage();
					$visitor->save();

					$currentChatSession->update(['last_step' => 'jenis_kelamin']);
					$this->wa->reply($message->getSender(), 'Silakan masukan jenis kelamin anda');
					return response()->json(['message' => 'success'], 200);
				}

				//Step kelima (poli)
				if($currentChatSession->get()->first()->last_step == 'jenis_kelamin'){
					$visitor = Visitor::firstOrNew([
						'chat_session_id' => $chatSession->id
					]);
					$visitor->jenis_kelamin = $message->getMessage();
					$visitor->save();

					$currentChatSession->update(['last_step' => 'poli']);
					$this->wa->reply($message->getSender(), 'Silakan masukan pilihan poli anda');
					return response()->json(['message' => 'success'], 200);
				}

				//Step keenam (confirm)
				if($currentChatSession->get()->first()->last_step == 'poli'){
					$visitor = Visitor::firstOrNew([
						'chat_session_id' => $chatSession->id
					]);
					$visitor->poli = $message->getMessage();
					$visitor->save();

					$currentChatSession->update(['last_step' => 'confirm']);

					$response = "Berikut ini adalah detail pendaftaran anda: \n" . 
								"Nama : $visitor->name \n" .
								"Tempat Lahir : $visitor->place_of_birth \n" .
								"Tanggal Lahir : $visitor->date_of_birth \n" .
								"Jenis Kelamin : $visitor->jenis_kelamin \n" .
								"Poli : $visitor->poli \n" .
								"Anda mendapat nomor antrian ke - $visitor->id";

					$this->wa->reply($message->getSender(), $response);
					return response()->json(['message' => 'success'], 200);
				}
			} else {
				// if(!in_array(strtolower($message->getMessage()), $allowedCommand = ['daftar'])){
				// 	$this->wa->reply($message->getSender(), 'Pesan yang anda kirim tidak sesuai format. Anda dapat melakukan pendaftaran pasien, balas pesan ini dengan kata "Daftar"');
				// } else {
					//Simpan Chat Session jika belum ada sebelumnya
					$chatSession = new ChatSession;
					$chatSession->sender = $message->getSender();
					$chatSession->last_step = 'new';
					$chatSession->save();

					return $this->wa->reply($message->getSender(), 'Anda dapat melakukan pendaftaran pasien, dengan mengirimkan kata "Daftar"');
				// }
			}
		 
		} else {
			
		}



    }
}
