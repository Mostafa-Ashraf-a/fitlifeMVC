<?php

namespace Database\Seeders;

use App\Models\WorkoutType;
use Illuminate\Database\Seeder;

class WorkoutTypeSeeder extends Seeder
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
                'id'         => 1,
                'value'      => 'Type 1'
            ],
            [
                'id'         => 2,
                'value'      => 'Type 2'
            ],
            [
                'id'         => 3,
                'value'      => 'Type 3'
            ],
            [
                'id'         => 4,
                'value'      => 'Type 4'
            ],[
                'id'         => 5,
                'value'      => 'Type 5'
            ],[
                'id'         => 6,
                'value'      => 'Type 6'
            ],[
                'id'         => 7,
                'value'      => 'Type 7'
            ],[
                'id'         => 8,
                'value'      => 'Type 8'
            ],[
                'id'         => 9,
                'value'      => 'Type 9'
            ],[
                'id'         => 10,
                'value'      => 'Type 10'
            ],[
                'id'         => 11,
                'value'      => 'Type 11'
            ],[
                'id'         => 12,
                'value'      => 'Type 12'
            ],[
                'id'         => 13,
                'value'      => 'Type 13'
            ],[
                'id'         => 14,
                'value'      => 'Type 14'
            ],[
                'id'         => 15,
                'value'      => 'Type 15'
            ],
            [
                'id'         => 16,
                'value'      => 'General'
            ],

        ];
        foreach($types as $type){
            WorkoutType::create($type);
        }
    }
}
