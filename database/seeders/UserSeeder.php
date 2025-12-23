<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'           => 'আশিকুর রহমান',
            'email'          => 'admin@mail.com',
            'password'       => Hash::make('1234'),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name'           => 'শাকিল আহমেদ',
            'email'          => 'shakil@mail.com',
            'password'       => Hash::make('1234'),
            'remember_token' => Str::random(10),
        ]);
    }
}
