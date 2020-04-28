<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Arr;
use Str;
use App\ChecklistItem;

class ChecklistItemController extends Controller
{
    /**
     * GET /checklist-items
     * Show all checklist-items that have been saved to the database
     */
    public function index()
    {
        $checklist_items = ChecklistItem::orderBy('item_number')->orderBy('created_at')->get();
        
        return view('checklist-items.index')->with([
            'checklistItems' => $checklist_items
        ]);
    }

    /*
     * GET /checklist-items/create
    */
    public function create()
    {
        return view('checklist-items.create');
    }

    /**
    * POST /checklist-items
    * Process the form for adding a new checklist item
    */
    public function store(Request $request)
    {
        # Validate the request data
        # The `$request->validate` method takes an array of data
        # where the keys are form inputs
        # and the values are validation rules to apply to those inputs
        $request->validate([
            # Lots of validation on item_number, a tinyint
            # Ref: https://dev.mysql.com/doc/refman/8.0/en/integer-types.html
            # Ref: https://laravel.com/docs/7.x/validation
            'item_number' => 'required|digits_between:1,3|integer|max:127',
            'item_name' => 'required',
            'plan_requirement' => 'required'
        ]);

        # Add the checklist item to the database
        $newItem = new ChecklistItem();
        $newItem->item_number = $request->item_number;
        $newItem->item_name = $request->item_name;
        $newItem->plan_requirement = $request->plan_requirement;
        $newItem->save();

        return redirect('/checklist-items')->with([
            'flash-alert' => 'Your checklist item “'.$newItem->plan_requirement.'” was added.'
        ]);
    }

    /*
     * GET /checklist-items/{id}/edit
    */
    public function edit(Request $request, $id)
    {
        $checklist_item = ChecklistItem::where('id', '=', $id)->first();

        return view('checklist-items.edit')->with([
            'item' => $checklist_item
        ]);
    }

    /**
     * PUT /checklist-items/{$id}
     */
    public function update(Request $request, $id)
    {
        $checklist_item = ChecklistItem::where('id', '=', $id)->first();

        # Validate the request data
        # The `$request->validate` method takes an array of data
        # where the keys are form inputs
        # and the values are validation rules to apply to those inputs
        $request->validate([
            # Lots of validation on item_number, a tinyint
            # Ref: https://dev.mysql.com/doc/refman/8.0/en/integer-types.html
            # Ref: https://laravel.com/docs/7.x/validation
            'item_number' => 'required|digits_between:1,3|integer|max:127',
            'item_name' => 'required',
            'plan_requirement' => 'required'
        ]);

        $checklist_item->id = $request->id;
        $checklist_item->item_number = $request->item_number;
        $checklist_item->item_name = $request->item_name;
        $checklist_item->plan_requirement = $request->plan_requirement;
        $checklist_item->save();
        
        return redirect('/checklist-items')->with([
            'flash-alert' => 'Your changes to “'.$checklist_item->plan_requirement.'” were saved.'
        ]);
    }

    /**
    * Deletes the checklist
    * DELETE /checklist-items/{id}
    */
    public function destroy($id)
    {
        $checklist_item = ChecklistItem::where('id', '=', $id)->first();

        $checklist_item->delete();

        return redirect('/checklist-items')->with([
            'flash-alert' => 'The checklist item “' . $checklist_item->plan_requirement . '” was removed.'
        ]);
    }
}
