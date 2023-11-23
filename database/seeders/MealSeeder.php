<?php

namespace Database\Seeders;

use App\Models\Meal;
use Illuminate\Database\Seeder;

class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $meals = [
            [
                'id'    => 1,
                'ar' => [
                    'title'        => "الفطار",
                ],
                'en' => [
                    'title'        => "BreakFast",
                ],
                'is_default'       => 1
            ],

            [
                'id'    => 2,
                'ar' => [
                    'title'        => "الغداء والعشاء",
                ],
                'en' => [
                    'title'        => "Dinner and Lunch",
                ],
                'is_default'       => 1
            ],

            [
                'id'    => 3,
                'ar' => [
                    'title'        => "وجبة خفيفة",
                ],
                'en' => [
                    'title'        => "Snack",
                ],
                'is_default'       => 1
            ],

        ];
        foreach($meals as $meal){
            Meal::create($meal);
        }
    }
}
