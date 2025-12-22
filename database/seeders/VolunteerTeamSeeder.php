<?php

namespace Database\Seeders;

use App\Models\VolunteerTeam;
use Illuminate\Database\Seeder;

class VolunteerTeamSeeder extends Seeder
{
    public function run(): void
    {
        $teams = [
            [
                'name' => 'Campaign & Community Engagement',
                'name_bn' => 'প্রচারণা ও কমিউনিটি এনগেজমেন্ট',
                'slug' => 'campaign',
                'icon' => '📢',
                'description' => 'Door-to-door campaigning, leaflet distribution, phone calls, miking',
                'description_bn' => 'পাড়া-মহল্লায় ভোটারদের সাথে কথা বলা, লিফলেট বিতরণ, ফোনকল, মাইকিং',
                'color' => 'blue',
                'member_count' => '১৫০০+',
                'order' => 1,
            ],
            [
                'name' => 'Public Meetings & Events',
                'name_bn' => 'জনসভা ও ইভেন্ট',
                'slug' => 'event',
                'icon' => '🎤',
                'description' => 'Organizing and managing meetings, courtyard sessions, voter gatherings',
                'description_bn' => 'সভা, উঠান বৈঠক, ভোটার আড্ডা আয়োজন ও পরিচালনা',
                'color' => 'green',
                'member_count' => '১২০০+',
                'order' => 2,
            ],
            [
                'name' => 'Election Day',
                'name_bn' => 'নির্বাচন দিবস',
                'slug' => 'election_day',
                'icon' => '🗳️',
                'description' => 'Polling agents, voter support and slip distribution',
                'description_bn' => 'পোলিং এজেন্ট, ভোটার সাপোর্ট ও স্লিপ বিতরণ',
                'color' => 'amber',
                'member_count' => '২০০০+',
                'order' => 3,
            ],
            [
                'name' => 'Media & Content',
                'name_bn' => 'মিডিয়া ও কনটেন্ট',
                'slug' => 'media_content',
                'icon' => '🎬',
                'description' => 'Social media content creation, writing, videography, photography, editing & graphic design',
                'description_bn' => 'সোশ্যাল মিডিয়া কনটেন্ট তৈরি, লেখালেখি, ভিডিওগ্রাফি, ফটোগ্রাফি, এডিটিং ও গ্রাফিক ডিজাইন',
                'color' => 'purple',
                'member_count' => '৮০০+',
                'order' => 4,
            ],
            [
                'name' => 'Research & Monitoring',
                'name_bn' => 'রিসার্চ ও মনিটরিং',
                'slug' => 'research',
                'icon' => '📊',
                'description' => 'Voter data collection and analysis, campaign monitoring',
                'description_bn' => 'ভোটার তথ্য, মাঠ তথ্য সংগ্রহ ও বিশ্লেষণ, ক্যাম্পেইন কার্যক্রম পর্যবেক্ষণ',
                'color' => 'teal',
                'member_count' => '৫০০+',
                'order' => 5,
            ],
            [
                'name' => 'Social Initiatives',
                'name_bn' => 'সামাজিক উদ্যোগ',
                'slug' => 'social',
                'icon' => '🏥',
                'description' => 'Medical camps and awareness programs',
                'description_bn' => 'মেডিকেল ক্যাম্প সহ সচেতনতামূলক কার্যক্রম',
                'color' => 'red',
                'member_count' => '৭০০+',
                'order' => 6,
            ],
            [
                'name' => 'Cultural Team',
                'name_bn' => 'সাংস্কৃতিক টিম',
                'slug' => 'cultural',
                'icon' => '🎭',
                'description' => 'Campaign songs, poetry and other cultural activities',
                'description_bn' => 'প্রচার, গান, কবিতা লেখা ও অন্যান্য সাংস্কৃতিক কার্যক্রম',
                'color' => 'pink',
                'member_count' => '৪০০+',
                'order' => 7,
            ],
            [
                'name' => 'Local Leadership',
                'name_bn' => 'স্থানীয় নেতৃত্ব',
                'slug' => 'local_leadership',
                'icon' => '🏘️',
                'description' => 'Ward/neighborhood level organization and coordination',
                'description_bn' => 'ওয়ার্ড/মহল্লা পর্যায়ে সংগঠন ও সমন্বয়',
                'color' => 'indigo',
                'member_count' => '১০০০+',
                'order' => 8,
            ],
            [
                'name' => 'Other Contributions',
                'name_bn' => 'অন্যান্য অবদান',
                'slug' => 'other',
                'icon' => '✨',
                'description' => 'Other ways to contribute',
                'description_bn' => 'আপনি কিভাবে অবদান রাখতে চান',
                'color' => 'gray',
                'member_count' => '৩০০+',
                'order' => 9,
            ],
        ];

        foreach ($teams as $team) {
            VolunteerTeam::create($team);
        }
    }
}
