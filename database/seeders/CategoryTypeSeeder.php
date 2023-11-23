<?php

namespace Database\Seeders;

use App\Models\CategoryType;
use Illuminate\Database\Seeder;

class CategoryTypeSeeder extends Seeder
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
                    'name'   => "التغذية"
                ],
                'en' => [
                    'name'   => "Nutrition"
                ],


            ],

            [
                'id'    => 2,
                'ar' => [
                    'name'   => "التمارين"
                ],
                'en' => [
                    'name'   => "Exercise"
                ],
            ],
            [
                'id'    => 3,
                'ar' => [
                    'name'   => "المنشورات"
                ],
                'en' => [
                    'name'   => "Post"
                ],
            ],
        ];
        foreach($types as $type){
            CategoryType::create($type);
        }
    }
}
