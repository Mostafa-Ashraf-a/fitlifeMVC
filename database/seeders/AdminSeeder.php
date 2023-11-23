<?php

namespace Database\Seeders;

use App\Models\Manager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Manager::create([
            'username'    => "Admin",
            'email'       => "admin@fitlife.com",
            'mobile'       => 512345678,
            'password'    => Hash::make('Lr8s<+vmJfVdU'),
        ]);

        Manager::create([
            'username'    => "eng-amroakram",
            'email'       => "eng-amroakram@fitlife.com",
            'mobile'       => 599916672,
            'password'    => Hash::make('mm2139539mm'),
        ]);
    }
}
