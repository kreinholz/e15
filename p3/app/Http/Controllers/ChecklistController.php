<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Arr;
use Str;
use App\Checklist;
use App\ChecklistItem;

class ChecklistController extends Controller
{
    /**
     * GET /checklists
     * Show all checklists that have been saved to the database
     */
    public function index()
    {
        $checklists = Checklist::orderBy('title')->get();
        
        return view('checklists.index')->with([
            'checklists' => $checklists
        ]);
    }
}
