<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # Example users required for CSCI E-15, p3 (modified to split out name into first_name and last_name):
        $user = User::updateOrCreate(
            ['email' => 'jill@harvard.edu', 'first_name' => 'Jill', 'last_name' => 'Harvard', 'job_title' => 'Safety Oversight Manager'],
            ['password' => Hash::make('helloworld')
        ]
        );
        
        $user = User::updateOrCreate(
            ['email' => 'jamal@harvard.edu', 'first_name' => 'Jamal', 'last_name' => 'Harvard'],
            ['password' => Hash::make('helloworld')
        ]
        );
    }
}
