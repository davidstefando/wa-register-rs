<?php

namespace App\Http\Controllers;

use App\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index()
    {
        $visitors = Visitor::whereNotNull('poli')->get();
        return view('visitor.index', compact('visitors'));
    }
}
