<?php

namespace Database\Seeders;

use App\Models\GoalType;
use Illuminate\Database\Seeder;

class GoalTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'id'    => 1,
                'title'   => "Gain"
            ],[
                'id'    => 2,
                'title' => "Lose"
            ],
            [
                'id'    => 3,
                'title' => "Maintain"
            ],
        ];
        foreach($types as $type){
            GoalType::create($type);
        }
    }
}
