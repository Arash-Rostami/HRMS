<?php

namespace Database\Seeders;

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
        // \App\Models\User::factory(10)->create();
        for ($i = 101; $i < 131; $i++) {
            \App\Models\Seat::create(['number' => $i, 'extension' => $i, 'location' => 'Floor 7 - Unit 39']);
        }
        for ($i = 201; $i < 240; $i++) {
            \App\Models\Seat::create(['number' => $i, 'extension' => $i, 'location' => 'Floor 9 - Unit 49']);
        }
        for ($i = 301; $i < 318; $i++) {
            \App\Models\Seat::create(['number' => $i, 'extension' => $i, 'location' => 'Floor 9 - Unit 50']);
        }


    }
}
