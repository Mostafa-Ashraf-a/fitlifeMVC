<?php

namespace Database\Seeders;

use App\Models\MealType;
use Illuminate\Database\Seeder;

class MealTypeSeeder extends Seeder
{

    public function run()
    {
        $mealTypes = [
            [
                'id'    => 1,
                'ar' => [
                    'title'        => "الفطار",
                ],
                'en' => [
                    'title'        => "BreakFast",
                ],

            ],

            [
                'id'    => 2,
                'ar' => [
                    'title'        => "الغداء والعشاء",
                ],
                'en' => [
                    'title'        => "Dinner and Lunch",
                ],
            ],

            [
                'id'    => 3,
                'ar' => [
                    'title'        => "وجبة خفيفة",
                ],
                'en' => [
                    'title'        => "Snack",
                ],
            ],

        ];
        foreach($mealTypes as $mealType){
            MealType::create($mealType);
        }
    }
}
