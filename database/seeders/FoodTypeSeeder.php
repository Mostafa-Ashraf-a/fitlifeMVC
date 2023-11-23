<?php

namespace Database\Seeders;

use App\Models\FoodType;
use Illuminate\Database\Seeder;

class FoodTypeSeeder extends Seeder
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
                    'title'   => "النشويات"
                ],
                'en' => [
                    'title'   => "Starches"
                ],
            ],
            [
                'id'    => 2,
                'ar' => [
                    'title'   => "الفواكه"
                ],
                'en' => [
                    'title'   => "Fruits"
                ],
            ], [
                'id'    => 3,
                'ar' => [
                    'title'   => "الخضروات"
                ],
                'en' => [
                    'title'   => "Vegetables"
                ],
            ],[
                'id'    => 4,
                'ar' => [
                    'title'   => "اللحوم"
                ],
                'en' => [
                    'title'   => "Meats"
                ],
            ],[
                'id'    => 5,
                'ar' => [
                    'title'   => "الألبان"
                ],
                'en' => [
                    'title'   => "Dairy"
                ],
            ],[
                'id'    => 6,
                'ar' => [
                    'title'   => "الزيوت"
                ],
                'en' => [
                    'title'   => "Oils"
                ],
            ],
        ];
        foreach($types as $type){
            FoodType::create($type);
        }
    }
}
