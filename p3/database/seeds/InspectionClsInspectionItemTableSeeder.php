<?php

use Illuminate\Database\Seeder;
use App\InspectionCls;
use App\InspectionItem;
use App\InspectionClsInspectionItem;

class InspectionClInspectionItemTableSeeder extends Seeder
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
        
        # Retrieve our 3 sets of InspectionItems
        $inspection_items = InspectionItem::all();
        $inspection_items_1 = $inspection_items->where('id', '>=', '1')->where('id', '<=', '11')->get();
        $inspection_items_2 = $inspection_items->where('id', '>', '11')->where('id', '<=', '14')->get();
        $inspection_items_3 = $inspection_items->where('id', '>', '14')->get();

        # Seed database with Many-to-Many relations for the inspection_cl_inspection_item pivot table
        foreach ($inspection_items_1 as $item) {
            $inspection_checklist_1->inspection_items()->save($item);
        }
        foreach ($inspection_items_2 as $item) {
            $inspection_checklist_2->inspection_items()->save($item);
        }
        foreach ($inspection_items_3 as $item) {
            $inspection_checklist_3->inspection_items()->save($item);
        }
    }
}
