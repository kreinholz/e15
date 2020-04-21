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

    /*
     * GET /checklists/create
    */
    public function create()
    {
        $checklist_items = ChecklistItem::orderBy('item_number')->orderBy('created_at')->get();
    
        return view('checklists.create')->with([
        'checklistItems' => $checklist_items
        ]);
    }

    /*
     * GET /checklists/{id}/edit
    */

    public function edit(Request $request, $id)
    {
        $checklist = Checklist::where('id', '=', $id)->first();
        
        $checklist_items = ChecklistItem::orderBy('item_number')->orderBy('created_at')->get();
    
        # This is where I will add code to create a third variable that is a filtered version of
        # the checklist_items database query results (not an additional query), only those results
        # associated with the current checklist id. We still want all checklist_items, so they can
        # be added to the current checklist if so desired.

        return view('checklists.edit')->with([
        'checklist' => $checklist,
        'checklistItems' => $checklist_items
        ]);
    }
}
