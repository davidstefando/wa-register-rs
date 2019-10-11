<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function __construct()
    {

    }

    public function process(Request $req)
    {
        switch ($req->type) {
            case '':
                # code...
                break;
            
            default:
                # code...
                break;
        }
    }

    private function processAck($ack)
    {

    }

    private function processMessage($message)
    {

    }
}
