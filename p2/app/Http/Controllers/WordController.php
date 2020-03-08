<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WordController extends Controller
{
    public function index($userInput = null)
    {
        if ($userInput) {
            return view('form')->with(['userInput' => $userInput]);
        } else {
            return view('form');
        }
    }
}
