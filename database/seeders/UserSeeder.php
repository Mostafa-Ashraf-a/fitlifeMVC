<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'full_name'    => "Smart Test",
            'email'        => "customer@smart.sa",
            'mobile'       => "512345678",
            'password'     => Hash::make('123456789'),
            'is_verified' => true,
            'otp_code'    => "12345",
            'goal'        => 1,
            'weight'      => 60,
            'height'      => 176,
            'level'       => 8,
            'gender'      => 1
        ]);
    }
}
