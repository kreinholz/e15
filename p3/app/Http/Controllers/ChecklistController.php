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

    /**
    * POST /checklists
    * Process the form for adding a new book
    */
    public function store(Request $request)
    {
        # Validate the request data
        # The `$request->validate` method takes an array of data
        # where the keys are form inputs
        # and the values are validation rules to apply to those inputs
        $request->validate([
            'title' => 'required'
        ]);

        # title and checklist_items[] are the 2 variables that should be returned by form data

        # Add the checklist to the database
        $newChecklist = new Checklist();
        $newChecklist->title = $request->title;
        $newChecklist->save();
        # Once the new checklist is added, add the checklist_items to the pivot table
        # Ref: https://laracasts.com/discuss/channels/laravel/saving-multiple-records-to-database-with-many-to-many-relation?page=1
        $newChecklist->checklist_items()->attach($request->checklist_items);

        return redirect('/checklists/create')->with([
            'flash-alert' => 'Your checklist '.$newChecklist->title.' was added.'
        ]);
    }

    /**
     * GET /checklists/{id}
     * Show the details for an individual checklist
     */
    public function show(Request $request, $id)
    {
        $checklist = Checklist::where('id', '=', $id)->first();

        $checklist_items = $checklist->checklist_items()->where('checklist_id', '=', $id)->get();

        return view('checklists.show')->with([
            'checklist' => $checklist,
            'id' => $id,
            'checklist_items' => $checklist_items
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
