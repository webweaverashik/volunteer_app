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
            'email'          => 'webweaverashik@mail.com',
            'password'       => Hash::make('p0!ce@Web#26'),
            'remember_token' => Str::random(10),
        ]);
    }
}
