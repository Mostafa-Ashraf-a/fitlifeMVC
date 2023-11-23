<?php

namespace Database\Seeders;

use App\Models\Goal;
use Illuminate\Database\Seeder;

class GoalSeeder extends Seeder
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
                'ar' => [
                    'title'   => "خسارة الدهون والوزن"
                ],
                'en' => [
                    'title'   => "Maintain weight"
                ],
            ],
            [
                'id'    => 2,
                'ar' => [
                    'title'   => "اكتساب العضلات والوزن"
                ],
                'en' => [
                    'title'   => "Gain muscles and weight"
                ],
            ],
             [
                'id'    => 3,
                'ar' => [
                    'title'   => "تفقد الدهون والوزن"
                ],
                'en' => [
                    'title'   => "Lose fat and weight"
                ],
            ]
        ];
        foreach($types as $type){
            Goal::create($type);
        }
    }
}
