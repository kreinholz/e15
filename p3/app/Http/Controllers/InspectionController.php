<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inspection;
use App\Checklist;
use App\ChecklistItem;
use App\User;
use App\InspectionCl;
use App\InspectionItem;

class InspectionController extends Controller
{
    # So much TO DO here. One thing that needs to be done, is when a user starts a new inspection,
    # s/he will select a checklist, and all checklist_items associated with that checklist will be
    # copied to a new table associated with the inspections table, to avoid mutating the date in
    # the original checklist_items table (since the answers will differ between inspections).


    /**
     * GET /inspections
    */
    public function index(Request $request)
    {
        # Query the database and return all inspections
        $inspections = Inspection::orderBy('rail_transit_agency')->orderBy('inspection_date')->get();

        # Query the database for the current user, based on the $request object from the session
        $user = User::where('id', '=', $request->user()->id)->first();

        # Return inspections associated with the current user, if any
        $my_inspections = $inspections->where('inspector_id', $user->id);
        
        return view('inspections.index')->with([
            'inspections' => $inspections,
            'user' => $user,
            'myInspections' => $my_inspections
        ]);
    }

    /**
     * GET /inspections/create
    */
    public function create()
    {
        $checklists = Checklist::orderBy('title')->get();
    
        return view('inspections.create')->with([
            'checklists' => $checklists
        ]);
    }

    /**
    * POST /inspections
    * Process the form for adding a new inspection
    */
    public function store(Request $request)
    {
        # Validate the request data
        # The `$request->validate` method takes an array of data
        # where the keys are form inputs
        # and the values are validation rules to apply to those inputs
        $request->validate([
            'rail_transit_agency' => 'required',
            'inspection_date' => 'required|date'
        ]);

        # Assuming form data passes validation, retrieve the selected checklist and eager load its associated checklist_items
        $checklist = Checklist::where('id', '=', $request->checklist)->with('checklist_items')->first();

        # Retrieve the checklist_items associated with the selected checklist
        $items = $checklist->checklist_items()->get();

        # Query the database for the current user, based on the $request object from the session
        $user = User::where('id', '=', $request->user()->id)->first();

        # Copy a 'snapshot' of the selected checklist and its associated checklist_items over to
        # the inspection_checklists and inspection_items database tables
        $newInspectionChecklist = new InspectionCl();
        $newInspectionChecklist->title = $checklist->title;
        $newInspectionChecklist->inspector_id = $user->id;
        $newInspectionChecklist->save();
        
        # Since there are likely more than one inspection_item, we need to loop through the collection
        foreach ($items as $item) {
            $newItem = new InspectionItem();
            $newItem->item_number = $item->item_number;
            $newItem->item_name = $item->item_name;
            $newItem->plan_requirement = $item->plan_requirement;
            $newItem->save();
            # Once the checklist and checklist_items are cloned, add to the pivot table
            # Ref: https://laracasts.com/discuss/channels/laravel/saving-multiple-records-to-database-with-many-to-many-relation?page=1
            $newInspectionChecklist->inspection_items()->attach($newItem);
        }

        # Now that the 3 associated tables have data saved to them, save the inspection itself
        $newInspection = new Inspection();
        $newInspection->rail_transit_agency = $request->rail_transit_agency;
        $newInspection->inspection_date = $request->inspection_date;
        $newInspection->inspector_id = $user->id;
        $newInspection->checklist_id = $newInspectionChecklist->id;
        $newInspection->completed = false;
        $newInspection->save();

        return redirect('/inspections')->with([
            'flash-alert' => 'Your inspection of '.$newInspection->rail_transit_agency.' with an inspection date of '.$newInspection->inspection_date.' was created.'
        ]);
    }

    /**
     * GET /inspections/{id}
     * Show the details for a completed inspection
     */
    public function show(Request $request, $id)
    {
        $inspection = Inspection::where('id', '=', $id)->first();

        $inspection_checklist = InspectionCl::where('id', '=', $inspection->checklist_id)->first();

        $inspection_items = $inspection_checklist->inspection_items()->get();

        $inspector = User::where('id', '=', $inspection->inspector_id)->first();

        # Query the database for the current user, based on the $request object from the session
        $user = User::where('id', '=', $request->user()->id)->first();

        return view('inspections.show')->with([
            'inspection' => $inspection,
            'id' => $id,
            'inspection_checklist' => $inspection_checklist,
            'inspection_items' => $inspection_items,
            'inspector' => $inspector,
            'user' => $user
        ]);
    }

    /**
     * GET /inspections/{id}/edit
     * Take the user to a page where s/he can edit an in-progress inspection
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
}
