<?php

use Illuminate\Database\Seeder;
use App\InspectionCl;
use App\InspectionItem;

class InspectionClsInspectionItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # Retrieve our 3 sets of InspectionItems
        # Ref: https://laravel.com/docs/5.8/queries#retrieving-results for usage of whereBetween
        $inspection_items = InspectionItem::orderBy('item_number')->orderBy('created_at')->get();
        $inspection_items_1 = $inspection_items->whereBetween('id', [1, 11])->get();
        $inspection_items_2 = $inspection_items->whereBetween('id', [12, 14])->get();
        $inspection_items_3 = $inspection_items->where('id', '>', '14')->get();

        # Retrieve our 3 InspectionChecklists (InspectionCls)
        $inspection_checklists = InspectionCl::all();
        $inspection_checklist_1 = $inspection_checklists->where('id', '=', '1')->first();
        $inspection_checklist_2 = $inspection_checklists->where('id', '=', '2')->first();
        $inspection_checklist_3 = $inspection_checklists->where('id', '=', '3')->first();

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
