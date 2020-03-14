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

        # Import dictionary of English language words from file, read into array
        # Ref: https://www.php.net/manual/en/function.file.php
        $words = file('https://raw.githubusercontent.com/dwyl/english-words/master/words.txt', FILE_IGNORE_NEW_LINES);

        # Now that we have our array of words, convert to lowercase, then
        # split the inputString into an array
        # Ref: https://www.php.net/manual/en/function.strtolower.php
        # Ref: https://www.php.net/manual/en/function.str-split.php
        $inputStringLowercase = strtolower($inputString);
        $inputStringArray = str_split($inputStringLowercase);

        # Iterate over each word in the $words array
        # Ref: https://www.php.net/manual/en/control-structures.foreach.php
        foreach ($words as $word) {
            # convert the current string to lowercase, then split it into an array
            $lowercaseWord = strtolower($word);
            $currentWordArray = str_split($lowercaseWord);

            # Create a new array containing the intersecting elements of our 2 arrays
            # Ref: https://www.php.net/manual/en/function.array-intersect.php
            #SLOW            $charsInCommon = array_intersect($currentWordArray, $inputStringArray);
            # TO DO - REWRITE THE ABOVE TO DISALLOW DUPLICATES IN $inputStringArray--ONLY USE EACH CHAR ONCE

            # Alternate way of comparing arrays
            $charsInCommon = [];
            # Ref: https://www.php.net/manual/en/function.in-array.php
            # Ref:
            foreach ($currentWordArray as $character) {
                $match = array_search($character, $inputStringArray);
                if ($match) {
                    array_push($charsInCommon, $inputStringArray[$match]);
                    unset($inputStringArray[$match]);
                } else {
                    continue;
                }
            }

            # Compare $charsInCommon to $currentWordArray
            if ($currentWordArray == $charsInCommon) {
                # If the matching characters account for every character in the current word,
                # push the current word in its string form to the $searchResults array.
                # Ref: https://www.php.net/manual/en/function.array-push.php
                array_push($searchResults, $word);
            }
        }

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
