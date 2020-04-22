<?php

use Illuminate\Database\Seeder;
use App\Checklist;

class ChecklistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # Seed database with checklists to which we can add checklist_items
        $list = Checklist::updateOrCreate(
            ['title' => '2020-04-22 Full Checklist']
        );

        $list = Checklist::updateOrCreate(
            ['title' => '2020-04-23 Short Checklist']
        );
    }
}
