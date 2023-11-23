<?php

namespace Database\Seeders;

use App\Models\BodyPart;
use Illuminate\Database\Seeder;

class BodyPartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $types = [
            "Shoulders" => ["id" => 1, "ar" => "الأكتاف"],
            "Chest" => ["id" => 2, "ar" => "الصدر"],
            "Quads" => ["id" => 3, "ar" => "الأفخاذ الأمامية"],
            "Biceps" => ["id" => 4, "ar" => "بايسبس"],
            "Abs" => ["id" => 5, "ar" => "البطن"],
            "Obliques" => ["id" => 6, "ar" => "البطن الجانبية"],
            "Forearms" => ["id" => 7, "ar" => "السواعد"],
            "Adductors" => ["id" => 8, "ar" => "الأفخاذ الداخلية"],
            "Traps" => ["id" => 9, "ar" => "الترابيس"],
            "Triceps" => ["id" => 10, "ar" => "ترايسبس"],
            "Hamstrings" => ["id" => 11, "ar" => "الأفخاد الخلفية"],
            "Calves" => ["id" => 12, "ar" => "الساق الخلفية"],
            "Back" => ["id" => 13, "ar" => "الظهر"],
            "Glutes" => ["id" => 14, "ar" => "الأرداف"],
            "Abductors" => ["id" => 15, "ar" => "الأفخاد الخارجية"],
            "Cardio" => ["id" => 16, "ar" => "كارديو"],
        ];

        foreach ($types as $en_name => $type) {
            BodyPart::create([
                'id'    => $type['id'],
                'ar' => [
                    'title' => $type['ar']
                ],
                'en' => [
                    'title' => $en_name
                ],
            ]);
        }
    }
}
