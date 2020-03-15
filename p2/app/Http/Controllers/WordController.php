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
            'inputString' => 'required|alpha'
        ]);

        # Note: if validation fails, it will redirect
        # back to `/` (page from which the form was submitted)
        
        # Start with an empty array of results; words that
        # match our search query will get added to this array
        $searchResults = [];

        # Get form data (default to null if no values exist)
        $inputString = $request->input('inputString', null);
        $reuse = $request->input('reuse', null);
        $alphabetical = $request->input('alphabetical', null);
        $length = $request->input('length', null);

        # Import dictionary of English language words from file, read into array
        # Ref: https://www.php.net/manual/en/function.file.php
        $words = file('https://raw.githubusercontent.com/dwyl/english-words/master/words_alpha.txt', FILE_IGNORE_NEW_LINES);

        # Now that we have our array of words, convert to lowercase, then
        # split the inputString into an array
        # Ref: https://www.php.net/manual/en/function.strtolower.php
        # Ref: https://www.php.net/manual/en/function.str-split.php
        $inputStringLowercase = strtolower($inputString);
        $inputStringArray = str_split($inputStringLowercase);
        # Add a throwaway value to the 0 key in $inputStringArray to avoid a bug whereby all
        # instances of the first character in the $inputString are ignored during match searching
        # Ref: https://www.php.net/manual/en/function.array-unshift.php
        array_unshift($inputStringArray, '1');

        # Iterate over each word in the $words array
        # Ref: https://www.php.net/manual/en/control-structures.foreach.php
        foreach ($words as $word) {
            # convert the current string to lowercase, then split it into an array
            $lowercaseWord = strtolower($word);
            $currentWordArray = str_split($lowercaseWord);

            # Initialize a charsInCommon placeholder array to track matches during iteration
            $charsInCommon = [];
            
            # Check whether user checked the box to reuse letters, and if so, use the
            # array_intersect() method to search the dictionary
            if ($reuse) {
                # Create a new array containing the intersecting elements of our 2 arrays
                # Ref: https://www.php.net/manual/en/function.array-intersect.php
                $charsInCommon = array_intersect($currentWordArray, $inputStringArray);
            } else {
                # If user didn't check the reuse letters box, search for matches in a slightly
                # more complicated (but more intuitive in terms of search results) way
                # Copy $inputStringArray to $tempInputStringArray to reset it after each iteration
                $tempInputStringArray = $inputStringArray;
                # Iterate over each character in the current word, using array-search to find the key of
                # any matching character in $tempInputStringArray. If a match is found, push to
                # $charsInCommon Array and remove from $tempInputStringArray (to avoid duplicate matches)
                # Ref: https://www.php.net/manual/en/function.array-search.php
                # Ref: https://www.php.net/manual/en/function.unset.php
                foreach ($currentWordArray as $character) {
                    $match = array_search($character, $tempInputStringArray);
                    if ($match) {
                        array_push($charsInCommon, $tempInputStringArray[$match]);
                        unset($tempInputStringArray[$match]);
                    }
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
            'reuse' => $reuse,
            'alphabetical' => $alphabetical,
            'length' => $length,
            'searchResults' => $searchResults
        ]);
    }

    # Initial page view--if session data exists, pre-fill form accordingly
    public function index()
    {
        return view('word')->with([
            'inputString' => session('inputString', null),
            'reuse' => session('reuse', null),
            'alphabetical' => session('alphabetical', null),
            'length' => session('length', null),
            'searchResults' => session('searchResults', null)
        ]);
    }
}
