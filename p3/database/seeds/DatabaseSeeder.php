<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ChecklistItemsTableSeeder::class);
        $this->call(ChecklistsTableSeeder::class);
        $this->call(ChecklistChecklistItemTableSeeder::class);
        // $this->call(InspectionsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
