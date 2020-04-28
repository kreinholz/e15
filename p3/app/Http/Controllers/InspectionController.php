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
}
