<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Arr;
use Str;

class WordController extends Controller
{
    public function process(Request $request)
    {
        $request->validate([
            'inputString' => 'required'
        ]);

        # Note: if validation fails, it will redirect
        # back to `/` (page from which the form was submitted)
        
        # Start with an empty array of results; words that
        # match our search query will get added to this array
        $searchResults = [];

        # Get form data (default to null if no values exist)
        $inputString = $request->input('inputString', null);
        $specialChars = $request->input('specialChars', null);
        $alphabetical = $request->input('alphabetical', null);
        $length = $request->input('length', null);

        # TO DO: import our dictionary of English language words and actually do something with the form data

        # Redirect back to the form with data/results stored in the session
        # Ref: https://laravel.com/docs/redirects#redirecting-with-flashed-session-data
        return redirect('/')->with([
            'inputString' => $inputString,
            'specialChars' => $specialChars,
            'alphabetical' => $alphabetical,
            'length' => $length,
            'searchResults' => $searchResults
        ]);
    }

    public function index()
    {
        return view('word')->with([
            'inputString' => session('inputString', null),
            'specialChars' => session('specialChars', null),
            'alphabetical' => session('alphabetical', null),
            'length' => session('length', null),
            'searchResults' => session('searchResults', null)
        ]);
    }
}
