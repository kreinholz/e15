<?php

use Illuminate\Database\Seeder;
use App\Checklist;
use App\InspectionCls;
use App\User;

class InspectionClsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # Retrieve our 2 previously seeded Checklists
        $checklist_1 = Checklist::where('title', '=', '2020-04-22 Full Checklist')->first();
        $checklist_2 = Checklist::where('title', '=', '2020-04-23 Short Checklist')->first();

        # Retrieve our 2 inspectors
        $inspector_1 = User::where('first_name', '=', 'Jill')->first();
        $inspector_2 = User::where('first_name', '=', 'Jamal')->first();

        # Now that we've retrieved data from Users and Checklists, seed new data to InspectionCls
        $inspection_checklist_1 = InspectionCl::updateOrCreate(
            ['title' => $checklist_1->title, 'inspector_id' => $inspector_1->id]
        );

        $inspection_checklist_2 = InspectionCl::updateOrCreate(
            ['title' => $checklist_1->title, 'inspector_id' => $inspector_2->id]
        );

        $inspection_checklist_3 = InspectionCl::updateOrCreate(
            ['title' => $checklist_2->title, 'inspector_id' => $inspector_2->id]
        );
    }
}
