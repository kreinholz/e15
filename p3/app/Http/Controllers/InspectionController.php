<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inspection;
use App\Checklist;
use App\ChecklistItem;
use App\User;
use App\InspectionChecklist;
use App\InspectionItem;

class InspectionController extends Controller
{
    # So much TO DO here. One thing that needs to be done, is when a user starts a new inspection,
    # s/he will select a checklist, and all checklist_items associated with that checklist will be
    # copied to a new table associated with the inspections table, to avoid mutating the date in
    # the original checklist_items table (since the answers will differ between inspections).


    /**
     * GET /checklists
    */
    public function index(Request $request)
    {
        # Query the database and return all inspections
        $inspections = Inspection::orderBy('rail_transit_agency')->orderBy('inspection_date')->get();
        
        #Query the database for the current user, based on the $request object from the session
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
     * GET /checklists/create
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

        #Query the database for the current user, based on the $request object from the session
        $user = User::where('id', '=', $request->user()->id)->first();

        # Copy a 'snapshot' of the selected checklist and its associated checklist_items over to
        # the inspection_checklists and inspection_items database tables
        $newInspectionChecklist = new InspectionChecklist();
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
        $newInspection->rail_transit_authority = $request->rail_transit_authority;
        $newInspection->inspection_date = $request->inspection_date;
        $newInspection->inspector_id = $user->id;
        $newInspection->inspection_checklist_id = $newInspectionChecklist->id;
        $newInspection->save();

        return redirect('/inspections')->with([
            'flash-alert' => 'Your inspection of '.$newInspection->rail_transit_authority.' with an inspection date of '.$newInspection->inspection_date.' was created.'
        ]);
    }
}
