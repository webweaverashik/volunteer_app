<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UpazilaSeeder::class,
            OccupationSeeder::class,
            VolunteerTeamSeeder::class,
            FAQSeeder::class,
            UserSeeder::class,
            // VolunteerSeeder::class
        ]);
    }
}
