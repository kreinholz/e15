<?php

declare(strict_types=1);

namespace App\Http\Controllers;

ini_set('memory_limit', '2048M');

use Illuminate\Http\Request;
use Arr;
use Str;
use Phpml\ModelManager;

class ClassifierController extends Controller
{
    public function classify(Request $request)
    {
        $request->validate([
            'articleText' => 'required|string'
        ]);

        # Note: if validation fails, it will redirect
        # back to `/` (page from which the form was submitted)

        # Get form data (default to null if no values exist)
        $articleText = $request->input('articleText', null);

        # Import saved Machine Learning model from file
        $modelManager = new ModelManager();
        $model = $modelManager->restoreFromFile('../resources/ml/bbc-nb.phpml');

        # Run our pre-trained model on the user-provided string of text
        $predicted = $model->predict([$articleText])[0];

        # Redirect back to the form with data/results stored in the session
        # Ref: https://laravel.com/docs/redirects#redirecting-with-flashed-session-data
        return redirect('/')->with([
            'articleText' => $articleText,
            'predicted' => $predicted
        ]);
    }

    # Initial page view--if session data exists, pre-fill form accordingly
    public function index()
    {
        return view('classifier')->with([
            'articleText' => session('articleText', null),
            'predicted' => session('predicted', null)
        ]);
    }
}
