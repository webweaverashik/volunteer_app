<?php

namespace Database\Seeders;

use App\Models\Upazila;
use Illuminate\Database\Seeder;

class UpazilaSeeder extends Seeder
{
    public function run(): void
    {
        $upazilas = [
            ['name' => 'Sylhet Sadar', 'name_bn' => 'সিলেট সদর', 'slug' => 'sylhet-sadar', 'is_sylhet3' => false, 'order' => 1],
            ['name' => 'Balaganj', 'name_bn' => 'বালাগঞ্জ', 'slug' => 'balaganj', 'is_sylhet3' => true, 'order' => 2],
            ['name' => 'Beanibazar', 'name_bn' => 'বিয়ানীবাজার', 'slug' => 'beanibazar', 'is_sylhet3' => false, 'order' => 3],
            ['name' => 'Bishwanath', 'name_bn' => 'বিশ্বনাথ', 'slug' => 'bishwanath', 'is_sylhet3' => false, 'order' => 4],
            ['name' => 'Companyganj', 'name_bn' => 'কোম্পানীগঞ্জ', 'slug' => 'companyganj', 'is_sylhet3' => false, 'order' => 5],
            ['name' => 'Fenchuganj', 'name_bn' => 'ফেঞ্চুগঞ্জ', 'slug' => 'fenchuganj', 'is_sylhet3' => true, 'order' => 6],
            ['name' => 'Golapganj', 'name_bn' => 'গোলাপগঞ্জ', 'slug' => 'golapganj', 'is_sylhet3' => false, 'order' => 7],
            ['name' => 'Goainghat', 'name_bn' => 'গোয়াইনঘাট', 'slug' => 'goainghat', 'is_sylhet3' => false, 'order' => 8],
            ['name' => 'Jaintapur', 'name_bn' => 'জৈন্তাপুর', 'slug' => 'jaintapur', 'is_sylhet3' => false, 'order' => 9],
            ['name' => 'Kanaighat', 'name_bn' => 'কানাইঘাট', 'slug' => 'kanaighat', 'is_sylhet3' => false, 'order' => 10],
            ['name' => 'Zakiganj', 'name_bn' => 'জকিগঞ্জ', 'slug' => 'zakiganj', 'is_sylhet3' => false, 'order' => 11],
            ['name' => 'Dakshin Surma', 'name_bn' => 'দক্ষিণ সুরমা', 'slug' => 'dakshin-surma', 'is_sylhet3' => true, 'order' => 12],
            ['name' => 'Osmaninagar', 'name_bn' => 'ওসমানীনগর', 'slug' => 'osmaninagar', 'is_sylhet3' => false, 'order' => 13],
        ];

        foreach ($upazilas as $upazila) {
            Upazila::create($upazila);
        }
    }
}
