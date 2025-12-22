<?php
namespace Database\Seeders;

use App\Models\Occupation;
use App\Models\Upazila;
use App\Models\Volunteer;
use App\Models\VolunteerTeam;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class VolunteerSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('bn_BD');

        // Safety checks
        if (Upazila::count() === 0 || Occupation::count() === 0) {
            $this->command->warn('VolunteerSeeder skipped: Upazila or Occupation table is empty.');
            return;
        }

        $upazilaIds    = Upazila::pluck('id')->toArray();
        $occupationIds = Occupation::pluck('id')->toArray();
        $teamIds       = VolunteerTeam::pluck('id')->toArray();

        $weeklyHours = ['1-4', '5-8', '9-12', '12+'];
        $times       = ['morning', 'noon', 'afternoon', 'evening', 'anytime'];
        $statuses    = ['pending', 'approved', 'rejected'];

        foreach (range(1, 50) as $i) {

            $volunteer = Volunteer::create([
                'full_name'              => $faker->name,
                'mobile'                 => '01' . rand(3, 9) . rand(10000000, 99999999),
                'nid'                    => rand(0, 1) ? rand(1000000000, 9999999999) : null,
                'sylhet3_resident'       => rand(0, 100) > 15, // most are residents
                'upazila_id'             => $faker->randomElement($upazilaIds),
                'union_name'             => $faker->city,
                'current_address'        => $faker->address,
                'voting_center'          => rand(0, 1) ? 'ভোট কেন্দ্র - ' . rand(1, 50) : null,
                'age'                    => rand(18, 65),
                'occupation_id'          => $faker->randomElement($occupationIds),
                'reference'              => rand(0, 1) ? $faker->name : null,
                'weekly_hours'           => $faker->randomElement($weeklyHours),
                'preferred_time'         => $faker->randomElement($times),
                'comments'               => rand(0, 1) ? 'স্বেচ্ছাসেবক হিসেবে কাজ করতে আগ্রহী।' : null,
                'other_team_description' => rand(0, 1) ? 'অনলাইন ক্যাম্পেইন ও মাঠ পর্যায়ে কাজ' : null,
                'status'                 => $faker->randomElement($statuses),
            ]);

            // Attach volunteer teams (if any)
            if (! empty($teamIds)) {
                $volunteer->teams()->attach(
                    $faker->randomElements($teamIds, rand(1, min(3, count($teamIds))))
                );
            }
        }

        $this->command->info('VolunteerSeeder completed successfully.');
    }
}
