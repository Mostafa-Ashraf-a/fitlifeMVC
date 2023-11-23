<?php

namespace Database\Seeders;

use App\Models\Answer;
use Illuminate\Database\Seeder;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $answers = [
            [
                'id'    => 1,
                'question_id' => 1,
                'ar' => [
                    'answer_content'   => "المحافظة على ثبات الوزن"
                ],
                'en' => [
                    'answer_content'   => "Maintain weight "
                ],
            ], [
                'id'    => 2,
                'question_id' => 1,
                'ar' => [
                    'answer_content'   => "اكتساب العضلات والوزن"
                ],
                'en' => [
                    'answer_content'   => "Gain muscles and weight"
                ],
            ], [
                'id'    => 3,
                'question_id' => 1,
                'ar' => [
                    'answer_content'   => "فقدان الدهون والوزن"
                ],
                'en' => [
                    'answer_content'   => "Lose fat and weight"
                ],
            ],

            [
                'id'    => 4,
                'question_id' => 2,
                'ar' => [
                    'answer_content'   => "لا يوجد نشاط"
                ],
                'en' => [
                    'answer_content'   => "No activity"
                ],
            ], [
                'id'    => 5,
                'question_id' => 2,
                'ar' => [
                    'answer_content'   => "نشاط منخفض ( ١-٢ أيام فالأسبوع )"
                ],
                'en' => [
                    'answer_content'   => "Slightly active(1-2 days/week)"
                ],
            ], [
                'id'    => 6,
                'question_id' => 2,
                'ar' => [
                    'answer_content'   => "نشاط معتدل ( ٣-٤ أيام فالأسبوع )"
                ],
                'en' => [
                    'answer_content'   => "Moderately active(3-4 days/week)"
                ],
            ], [
                'id'    => 7,
                'question_id' => 2,
                'ar' => [
                    'answer_content'   => "نشاط عالي ( ٥-٦ أيام فالأسبوع )"
                ],
                'en' => [
                    'answer_content'   => "Active person(5-6 days/week)"
                ],
            ],

            [
                'id'    => 8,
                'question_id' => 3,
                'ar' => [
                    'answer_content'   => "مبتدئ"
                ],
                'en' => [
                    'answer_content'   => "Beginner"
                ],
            ], [
                'id'    => 9,
                'question_id' => 3,
                'ar' => [
                    'answer_content'   => "متوسط"
                ],
                'en' => [
                    'answer_content'   => "Intermediate"
                ],
            ], [
                'id'    => 10,
                'question_id' => 3,
                'ar' => [
                    'answer_content'   => "خبير"
                ],
                'en' => [
                    'answer_content'   => "Expert"
                ],
            ],

            [
                'id'    => 11,
                'question_id' => 4,
                'ar' => [
                    'answer_content'   => "0.5 كجم في الأسبوع"
                ],
                'en' => [
                    'answer_content'   => "0.5 Kg Per week"
                ],
            ], [
                'id'    => 12,
                'question_id' => 4,
                'ar' => [
                    'answer_content'   => "1 كجم في الأسبوع"
                ],
                'en' => [
                    'answer_content'   => "1 Kg Per week"
                ],
            ],

            [
                'id'    => 13,
                'question_id' => 5,
                'ar' => [
                    'answer_content'   => "0.5 كجم في الأسبوع"
                ],
                'en' => [
                    'answer_content'   => "0.5 Kg Per week"
                ],
            ],
            [
                'id'    => 14,
                'question_id' => 5,
                'ar' => [
                    'answer_content'   => "1 كجم في الأسبوع"
                ],
                'en' => [
                    'answer_content'   => "1 Kg Per week"
                ],
            ],

            [
                'id'    => 15,
                'question_id' => 6,
                'ar' => [
                    'answer_content'   => "نعم"
                ],
                'en' => [
                    'answer_content'   => "Yes"
                ],
            ], [
                'id'    => 16,
                'question_id' => 6,
                'ar' => [
                    'answer_content'   => "لا"
                ],
                'en' => [
                    'answer_content'   => "No"
                ],
            ],

            [
                'id'    => 17,
                'question_id' => 7,
                'ar' => [
                    'answer_content'   => "نعم"
                ],
                'en' => [
                    'answer_content'   => "Yes"
                ],
            ], [
                'id'    => 18,
                'question_id' => 7,
                'ar' => [
                    'answer_content'   => "لا"
                ],
                'en' => [
                    'answer_content'   => "No"
                ],
            ],


        ];
        foreach ($answers as $answer) {
            Answer::create($answer);
        }
    }
}
