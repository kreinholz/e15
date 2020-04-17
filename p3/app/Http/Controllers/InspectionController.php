<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inspection;
use App\Checklist;
use App\ChecklistItem;

class InspectionController extends Controller
{
    # So much TO DO here. One thing that needs to be done, is when a user starts a new inspection,
    # s/he will select a checklist, and all checklist_items associated with that checklist will be
    # copied to a new table associated with the inspections table, to avoid mutating the date in
    # the original checklist_items table (since the answers will differ between inspections).
    # One possible ref is https://laraveldaily.com/quick-replication-of-model-row/
    # Another ref is https://stackoverflow.com/questions/46991021/copy-one-row-from-one-table-to-another

    # Another possibility is utilizing the create() method as outlined in the Laravel documentation:
    # Ref: https://laravel.com/docs/7.x/eloquent-relationships#inserting-and-updating-related-models

    public function index()
    {
        $inspections = Inspection::orderBy('rail_transit_agency')->orderBy('inspection_date')->get();
        
        return view('inspections.index')->with([
            'inspections' => $inspections
        ]);
    }
}
