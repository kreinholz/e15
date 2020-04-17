<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * GET /
     */
    public function welcome(Request $request)
    {
        $user = $request->user();

        $userName = null;
        
        if ($request->user()) {
            $userName = $user->first_name . ' ' . $user->last_name;
        }

        # Return the view, making the above data available for use in the video
        return view('welcome')->with([
            'userName' => $userName ?? null
        ]);
    }
}
