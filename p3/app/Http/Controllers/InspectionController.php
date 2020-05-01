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
        $inspection = Inspection::where('id', '=', $id)->first();

        $inspection_checklist = InspectionCl::where('id', '=', $inspection->checklist_id)->first();

        $inspection_items = $inspection_checklist->inspection_items()->get();

        $inspector = User::where('id', '=', $inspection->inspector_id)->first();

        # Query the database for the current user, based on the $request object from the session
        $user = User::where('id', '=', $request->user()->id)->first();

        return view('inspections.edit')->with([
            'inspection' => $inspection,
            'id' => $id,
            'inspectionChecklist' => $inspection_checklist,
            'inspectionItems' => $inspection_items,
            'inspector' => $inspector,
            'user' => $user
        ]);
    }

    /**
     * PUT /inspections/{$id}
     */
    public function update(Request $request, $id)
    {
        # Validate the request data
        # The `$request->validate` method takes an array of data
        # where the keys are form inputs
        # and the values are validation rules to apply to those inputs
        $request->validate([
                    'rail_transit_agency' => 'required',
                    'inspection_date' => 'required|date',
                ]);

        # We cannot simply grab one each of:
        #           'included' => 'boolean',
        #           'page_reference' => 'integer',
        # Because each inspection_item has one, and we are dealing with multiple inspection_items. So,
        # we either have to update each separately, or grab them in arrays and iterate over them...

        $inspection = Inspection::where('id', '=', $id)->first();

        $inspection_checklist = InspectionCl::where('id', '=', $inspection->checklist_id)->first();

        $inspection_items = $inspection_checklist->inspection_items()->get();

        $inspector = User::where('id', '=', $inspection->inspector_id)->first();

        # Query the database for the current user, based on the $request object from the session
        $user = User::where('id', '=', $request->user()->id)->first();

        # TO DO: This is where I will add code to update the correct row in the inspections table,
        # the inspection_cls table (if the Safety Oversight Manager takes over the inspection from
        # an ordinary user and therefore the inspector_id field needs to be updated), and the
        # correct rows in the many-to-many associated inspection_items, where for the first time
        # the inspector can fill in such information as a boolean for whether the item is included,
        # the page reference, and comments. Note that none of these fields are marked as "required"
        # because we don't want to force the inspector to submit one set of form data at the end of
        # an inspection--we want him/her to be able to save updates as s/he goes along. When finished
        # with an inspection, the inspector will check the box to change the boolean for completed
        # from its default value of false to true.

        $inspection->id = $request->id;
        $inspection->rail_transit_agency = $request->rail_transit_agency;
        $inspection->inspection_date = $request->inspection_date;
        # Normally the inspector won't change, but if a new inspector takes over, we want the
        # inspection to be associated with that new inspector. Note that we're updating the
        # inspector in the inspections table, but not in the inspection_cls (inspection_checklists)
        # table, so we can retain information in the database about which inspector originally began
        # the inspection, in case the Safety Oversight Manager wants to track this information.
        $inspection->inspector_id = $user->id;
        $inspection->save();

        # Now that we've updated the appropriate row in the inspection table, it's time to update
        # the inspection_items indirectly associated with the inspection via the inspection_cls
        # table and its Many-to-Many relationship with inspection_items.
        
        # First step, we want to convert all our numbered form data for included, page_reference,
        # and comments into a more usable format
        $inspection_items = [];
        # Now that we've initialized an empty object to hold our data, we need to loop through the
        # $request data and save each included, page_reference, and comment to the $inspection_items
        # array, and add an id field since we can't rely on the array index to accurately reflect what's
        # in the database. (For starters, an array starts indexing at 0, and our inspection_items begin
        # at 1, to say nothing of the possibility of skipped items not included in this inspection checklist)
        

        return redirect('/inspections/'.$id.'/edit')->with([
            'flash-alert' => 'Your changes were saved.'
        ]);
    }
}
