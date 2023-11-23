<?php

namespace Database\Seeders;

use App\Models\Serving;
use Illuminate\Database\Seeder;

class UserServingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Serving::create([
            'user_id'     => 1,
            'status'      => 1,
            'plan_status' => 0,
            'starches'    => 9,
            'fruits'      => 8,
            'vegetables'  => 7,
            'meats'       => 6,
            'dairy'       => 5,
            'oils'        => 10,
        ]);
    }
}
