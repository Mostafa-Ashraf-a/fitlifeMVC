<?php

namespace Database\Seeders;

use App\Models\Day;
use Illuminate\Database\Seeder;

class DaySeeder extends Seeder
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
                'id'     => 1,
                'value'  => 'Day One',
                'day'    => 1,
            ],
            [
                'id'     => 2,
                'value'  => 'Day Two',
                'day'    => 2,
            ],
            [
                'id'     => 3,
                'value'  => 'Day Three',
                'day'    => 3,
            ],
            [
                'id'     => 4,
                'value'  => 'Day Four',
                'day'    => 4,
            ],
            [
                'id'     => 5,
                'value'  => 'Day Five',
                'day'    => 5,
            ],
            [
                'id'     => 6,
                'value'  => 'Day Six',
                'day'    => 6,
            ],
            [
                'id'     => 7,
                'value'  => 'Day Seven',
                'day'    => 7,
            ],
        ];
        foreach($types as $type){
            Day::create($type);
        }
    }
}
