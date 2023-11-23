<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $levels = [
            [
                'id'    => 1,
                'ar' => [
                    'title'        => "مبتدئ",
                ],
                'en' => [
                    'title'        => "Beginners",
                ],
            ],

            [
                'id'    => 2,
                'ar' => [
                    'title'         => "متوسط",
                ],
                'en' => [
                    'title'        => "Intermediates",
                ],
            ],

            [
                'id'    => 3,
                'ar' => [
                    'title'         => "متقدم",
                ],
                'en' => [
                    'title'       => "Advanced",
                ],
            ],

        ];
        foreach ($levels as $level) {
            Level::create($level);
        }
    }
}
