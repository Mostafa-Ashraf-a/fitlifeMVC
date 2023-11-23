<?php

namespace Database\Seeders;

use App\Models\Equipment;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $equipments = [
        //     [
        //         'id'    => 1,
        //         'ar' => [
        //             'title'   => "مجموعة الدمبل"
        //         ],
        //         'en' => [
        //             'title'   => "Dumbbell set"
        //         ],
        //     ],

        //     [
        //         'id'    => 2,
        //         'ar' => [
        //             'title'   => "جهاز السير المتحرك"
        //         ],
        //         'en' => [
        //             'title'   => "Treadmill"
        //         ],
        //     ],

        //     [
        //         'id'    => 3,
        //         'ar' => [
        //             'title'   => "مجموعة الحديد"
        //         ],
        //         'en' => [
        //             'title'   => "Barbell Set"
        //         ],
        //     ],
        //     [
        //         'id'    => 4,
        //         'ar' => [
        //             'title'   => "آلة التجديف"
        //         ],
        //         'en' => [
        //             'title'   => "Rowing machine"
        //         ],
        //     ],
        //     [
        //         'id'    => 5,
        //         'ar' => [
        //             'title'   => "مقعد التدريب"
        //         ],
        //         'en' => [
        //             'title'   => "Training bench"
        //         ],
        //     ],
        // ];

        $equipments = [
            "Dumbbells" => "الدامبل",
            "Barbell" => "باربل",
            "Barbell and Bench" => "الدامبل و مقعد",
            "Dumbbells and Bench" => "باربل و مقعد",
            "Barbell and Preacher" => "باربل و كرسي روماني",
            "Dumbbells and Preacher" => "الدامبل و كرسي روماني",
            "Machine" => "جهاز",
            "Plate" => "الوزن الدائري",
            "Cable and Bench" => "كيبل و مقعد",
            "Cable" => "كيبل",
            "Bench" => "مقعد",
            "Bodyweight" => "وزن الجسم",
            "Ball" => "الكرة",
            "Kettlebells" => "كيتل بيل",
            "Plate & Bench" => "الوزن الدائري و مقعد",
            "Physio Ball" => "كرة طبية",
            "Wheel Roll" => "العجلة",
            "Resistance Band" => "حبل المقاومة",
        ];

        $count = 1;

        foreach ($equipments as $en_equipment => $ar_equipment) {
            Equipment::create([
                'id'    => $count,
                'ar' => [
                    'title'   => $ar_equipment
                ],
                'en' => [
                    'title'   => $en_equipment
                ],
            ],);

            $count = $count + 1;
        }
    }
}
