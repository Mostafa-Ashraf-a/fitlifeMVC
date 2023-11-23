<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
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
                    'title'   => "تيست 1"
                ],
                'en' => [
                    'title'   => "Test 1"
                ],
                'category_type_id'  => 1
            ],

            [
                'id'    => 2,
                'ar' => [
                    'title'   => "تيست 2"
                ],
                'en' => [
                    'title'   => "Test 2"
                ],
                'category_type_id'  => 2
            ],

            [
                'id'    => 3,
                'ar' => [
                    'title'   => "تيست 3"
                ],
                'en' => [
                    'title'   => "Test 3"
                ],
                'category_type_id'  => 3
            ]

        ];

        foreach($types as $type){
            Category::create($type);
        }

    }
}
