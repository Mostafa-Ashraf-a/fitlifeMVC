<?php

namespace Database\Seeders;

use App\Models\ExerciseType;
use Illuminate\Database\Seeder;

class ExerciseTypeSeeder extends Seeder
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
                'type'   => 1,
                'ar' => [
                    'value'   => "قبل"
                ],
                'en' => [
                    'value'   => "Pre"
                ],
            ], [
                'id'    => 2,
                'type'   => 2,
                'ar' => [
                    'value'   => "رئيسي"
                ],
                'en' => [
                    'value'   => "Main"
                ],
            ], [
                'id'    => 3,
                'type'   => 3,
                'ar' => [
                    'value'   => "بعد"
                ],
                'en' => [
                    'value'   => "Post"
                ],
            ], [
                'id'    => 4,
                'type'   => 4,
                'ar' => [
                    'value'   => "الكارديو"
                ],
                'en' => [
                    'value'   => "Cardio"
                ],
            ],

        ];
        foreach ($types as $type) {
            ExerciseType::create($type);
        }
    }
}
