<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name'           => 'Ashikur Rahman',
                'email'          => 'admin@mail.com',
                'password'       => Hash::make('1234'),
                'role'           => 'admin',
                'remember_token' => Str::random(10),
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}
