<?php

use Illuminate\Database\Seeder;
use App\Checklist;
use App\InspectionCl;
use App\ChecklistItem;
use App\ChecklistChecklistItem;
use App\InspectionItem;

class InspectionItemsTableSeeder extends Seeder
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

        # Retrieve the 2 sets of ChecklistItems associated with the 2 Checklists
        $checklist_items = ChecklistItem::all();
        $checklists = Checklist::all();
        $checklist_1 = $checklists->where('id', '=', '1')->first();
        $checklist_2 = $checklists->where('id', '=', '2')->first();
        $checklist_items_list_1 = $checklist_1->checklist_items()->orderBy('item_number')->orderBy('created_at')->get();
        $checklist_items_list_3 = $checklist_2->checklist_items()->orderBy('item_number')->orderBy('created_at')->get();
        $checklist_items_list_2 = $checklist_items_list_1;

        # Now that data is retrieved, seed to InspectionItems
        foreach ($checklist_items_list_1 as $item) {
            $inspection_item = InspectionItem::updateOrCreate(
                ['item_number' => $item->item_number, 'item_name' => $item->item_name, 'plan_requirement' => $item->plan_requirement]
            );
        }

        foreach ($checklist_items_list_2 as $item) {
            $inspection_item = InspectionItem::updateOrCreate(
                ['item_number' => $item->item_number, 'item_name' => $item->item_name, 'plan_requirement' => $item->plan_requirement, 'included' => true, 'page_reference' => rand(1, 20), 'comments' => 'This is a test comment generated from seed data.']
            );
        }

        foreach ($checklist_items_list_3 as $item) {
            $inspection_item = InspectionItem::updateOrCreate(
                ['item_number' => $item->item_number, 'item_name' => $item->item_name, 'plan_requirement' => $item->plan_requirement, 'included' => true, 'page_reference' => rand(1, 20), 'comments' => 'This is a test comment generated from seed data.']
            );
        }
    }
}
