<?php

use Illuminate\Database\Seeder;
use App\ChecklistItem;

class ChecklistItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # Seed database with checklist items from which to build checklists and run inspections
        $item = ChecklistItem::updateOrCreate(
            ['item_number' => 1, 'item_name' => 'Policy Statement', 'plan_requirement' => 'A policy statement is developed for the System Safety Program Plan (SSPP).']
        );

        $item = ChecklistItem::updateOrCreate(
            ['item_number' => 1, 'item_name' => 'Policy Statement', 'plan_requirement' => 'The policy statement describes the authority that establishes the system safety program plan.']
        );

        $item = ChecklistItem::updateOrCreate(
            ['item_number' => 1, 'item_name' => 'Policy Statement', 'plan_requirement' => 'The policy statement is signed and endorsed by the rail transit agency\'s chief executive.']
        );

        $item = ChecklistItem::updateOrCreate(
            ['item_number' => 2, 'item_name' => 'Purpose, Goals and Objectives', 'plan_requirement' => 'The purpose of the SSPP is defined.']
        );

        $item = ChecklistItem::updateOrCreate(
            ['item_number' => 2, 'item_name' => 'Purpose, Goals and Objectives', 'plan_requirement' => 'Goals are identified to ensure that the SSPP fulfills its purpose.']
        );

        $item = ChecklistItem::updateOrCreate(
            ['item_number' => 2, 'item_name' => 'Purpose, Goals and Objectives', 'plan_requirement' => 'Objectives are identified to monitor and assess the achievement of goals.']
        );

        $item = ChecklistItem::updateOrCreate(
            ['item_number' => 2, 'item_name' => 'Purpose, Goals and Objectives', 'plan_requirement' => 'Stated management responsibilities are identified for the safety program to ensure that the goals and objectives are achieved.']
        );

        $item = ChecklistItem::updateOrCreate(
            ['item_number' => 3, 'item_name' => 'Management Structure', 'plan_requirement' => 'An overview of the management structure of the rail transit agency is provided including an organization chart.']
        );

        $item = ChecklistItem::updateOrCreate(
            ['item_number' => 3, 'item_name' => 'Management Structure', 'plan_requirement' => 'Organizational structure is clearly defined and includes (1) History and scope of service, (2) Physical characteristics, and (3) Operations and Maintenance.']
        );

        $item = ChecklistItem::updateOrCreate(
            ['item_number' => 3, 'item_name' => 'Management Structure', 'plan_requirement' => 'A description of how the safety function is integrated into the rest of the rail transit organization is provided.']
        );

        $item = ChecklistItem::updateOrCreate(
            ['item_number' => 3, 'item_name' => 'Management Structure', 'plan_requirement' => 'Clear identification of the lines of authority used by the rail transit agency to manage safety issues is provided.']
        );
    }
}
