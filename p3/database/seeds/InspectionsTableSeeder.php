<?php

use Illuminate\Database\Seeder;
use App\User;
use App\InspectionCls;
use App\Inspection;

class InspectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # Retrieve our 3 InspectionChecklists (InspectionCls)
        $inspection_checklists = InspectionCl::all();
        $inspection_checklist_1 = $inspection_checklists->where('id', '=', '1')->first();
        $inspection_checklist_2 = $inspection_checklists->where('id', '=', '2')->first();
        $inspection_checklist_3 = $inspection_checklists->where('id', '=', '3')->first();
        
        # Retrieve our 2 inspectors
        $inspector_1 = User::where('first_name', '=', 'Jill')->first();
        $inspector_2 = User::where('first_name', '=', 'Jamal')->first();
        
        # Now that we've retrieved data from Users and Checklists, seed new data to InspectionCls
        $inspection_1 = Inspection::updateOrCreate(
            ['rail_transit_agency' => 'Acme Railway Company', 'inspector_id' => $inspector_1->id, 'inspection_date' => '2020-03-19', 'checklist_id' => $inspection_checklist_1->id]
        );
        
        $inspection_2 = Inspection::updateOrCreate(
            ['rail_transit_agency' => 'Atlantic Railway Authority', 'inspector_id' => $inspector_2->id, 'inspection_date' => '2020-04-15', 'checklist_id' => $inspection_checklist_1->id, 'completed' => true]
        );
        
        $inspection_3 = Inspection::updateOrCreate(
            ['rail_transit_agency' => 'Zebra Railways', 'inspector_id' => $inspector_2->id, 'inspection_date' => '2020-05-03', 'checklist_id' => $inspection_checklist_2->id]
        );
    }
}
