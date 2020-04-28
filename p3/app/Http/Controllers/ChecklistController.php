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
    * Process the form for adding a new checklist
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
    
        # Get the current checklist_items associated with this checklist
        $existing_items = $checklist->checklist_items()->get();

        # Compare the collection of all checklist_items to existing_items already associated with the checklist
        # Ref: https://laravel.com/docs/5.2/collections#method-diff
        $new_items = $checklist_items->diff($existing_items);

        return view('checklists.edit')->with([
            'checklist' => $checklist,
            'newItems' => $new_items,
            'existingItems' => $existing_items
        ]);
    }

    /**
     * PUT /checklists/{$id}
     */
    public function update(Request $request, $id)
    {
        $checklist = Checklist::where('id', '=', $id)->first();

        # Validate the request data
        # The `$request->validate` method takes an array of data
        # where the keys are form inputs
        # and the values are validation rules to apply to those inputs
        $request->validate([
            'title' => 'required'
        ]);

        # title, existing_items[], and new_items[] are the 3 variables that should be returned by form data

        $checklist->id = $request->id;
        $checklist->save();
        # Once the checklist is saved, remove previous checklist_items
        $checklist->checklist_items()->detach();
        # Add remaining checklist_items to the pivot table
        # Ref: https://laracasts.com/discuss/channels/laravel/saving-multiple-records-to-database-with-many-to-many-relation?page=1
        # Ref: https://php.net/manual/en/function.array-merge.php
        $checklist_items = [];
        $existing_items = $request->existing_items;
        $new_items = $request->new_items;
        if ($existing_items && $new_items) {
            $checklist_items = array_merge($existing_items, $new_items);
        } elseif ($existing_items) {
            $checklist_items = $existing_items;
        } elseif ($new_items) {
            $checklist_items = $new_items;
        }
        # Make sure we have at least one checklist_item rather than a null array
        if ($checklist_items) {
            $checklist->checklist_items()->attach($checklist_items);
        }
        
        return redirect('/checklists/'.$id.'/edit')->with([
            'flash-alert' => 'Your changes were saved.'
        ]);
    }

    /**
    * Asks user to confirm they want to delete the checklist
    * GET /checklists/{id}/delete
    */
    public function delete($id)
    {
        $checklist = Checklist::where('id', '=', $id)->first();

        if (!$checklist) {
            return redirect('/checklists')->with([
                'flash-alert' => 'Checklist not found'
            ]);
        }

        return view('checklists.delete')->with([
            'checklist' => $checklist,
        ]);
    }

    /**
    * Deletes the checklist
    * DELETE /checklists/{id}
    */
    public function destroy($id)
    {
        $checklist = Checklist::where('id', '=', $id)->first();

        $checklist->checklist_items()->detach();

        $checklist->delete();

        return redirect('/checklists')->with([
            'flash-alert' => 'The “' . $checklist->title . '” checklist was removed.'
        ]);
    }
}
