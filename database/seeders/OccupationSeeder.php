<?php

namespace Database\Seeders;

use App\Models\Occupation;
use Illuminate\Database\Seeder;

class OccupationSeeder extends Seeder
{
    public function run(): void
    {
        $occupations = [
            ['name' => 'Student', 'name_bn' => 'শিক্ষার্থী', 'slug' => 'student', 'order' => 1],
            ['name' => 'Teacher', 'name_bn' => 'শিক্ষক', 'slug' => 'teacher', 'order' => 2],
            ['name' => 'Doctor', 'name_bn' => 'ডাক্তার', 'slug' => 'doctor', 'order' => 3],
            ['name' => 'Engineer', 'name_bn' => 'ইঞ্জিনিয়ার', 'slug' => 'engineer', 'order' => 4],
            ['name' => 'Lawyer', 'name_bn' => 'আইনজীবী', 'slug' => 'lawyer', 'order' => 5],
            ['name' => 'Businessman', 'name_bn' => 'ব্যবসায়ী', 'slug' => 'businessman', 'order' => 6],
            ['name' => 'Government Employee', 'name_bn' => 'সরকারি চাকরিজীবী', 'slug' => 'govt-employee', 'order' => 7],
            ['name' => 'Private Employee', 'name_bn' => 'বেসরকারি চাকরিজীবী', 'slug' => 'private-employee', 'order' => 8],
            ['name' => 'Farmer', 'name_bn' => 'কৃষক', 'slug' => 'farmer', 'order' => 9],
            ['name' => 'Expatriate', 'name_bn' => 'প্রবাসী', 'slug' => 'expatriate', 'order' => 10],
            ['name' => 'Housewife', 'name_bn' => 'গৃহিণী', 'slug' => 'housewife', 'order' => 11],
            ['name' => 'Other', 'name_bn' => 'অন্যান্য', 'slug' => 'other', 'order' => 12],
        ];

        foreach ($occupations as $occupation) {
            Occupation::create($occupation);
        }
    }
}
