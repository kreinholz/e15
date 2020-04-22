<?php

use Illuminate\Database\Seeder;
use App\Checklist;
use App\ChecklistItem;

class ChecklistChecklistItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # Seed database with Many-to-Many relations for the checklist_checklist_item pivot table
        $checklist_items = ChecklistItem::orderBy('item_number')->orderBy('created_at')->get();

        $checklist_1 = Checklist::where('title', '=', '2020-04-22 Full Checklist')->first();

        $checklist_2 = Checklist::where('title', '=', '2020-04-23 Short Checklist')->first();

        $checklist_item_1 = $checklist_items->find(1);

        $checklist_item_2 = $checklist_items->find(4);

        $checklist_item_3 = $checklist_items->find(8);

        foreach ($checklist_items as $item) {
            $checklist_1->checklist_items()->save($item);
        }

        $checklist_2->checklist_items()->save($checklist_item_1);
        $checklist_2->checklist_items()->save($checklist_item_2);
        $checklist_2->checklist_items()->save($checklist_item_3);
    }
}
