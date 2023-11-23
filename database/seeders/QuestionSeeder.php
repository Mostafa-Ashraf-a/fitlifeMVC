<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = [
            [
                'id'    => 1,
                'ar' => [
                    'question_content'   => "هل تريد ؟"
                ],
                'en' => [
                    'question_content'   => "Do you want to ?"
                ],

            ], [
                'id'    => 2,
                'ar' => [
                    'question_content'   => "أدخل شدة نشاطك لتحقيق هدفك"
                ],
                'en' => [
                    'question_content'   => "Enter your activity intensity for your goal ?"
                ],

            ], [
                'id'    => 3,
                'ar' => [
                    'question_content'   => "اختر مستواك في تمارين المقاومة (رفع الأثقال)"
                ],
                'en' => [
                    'question_content'   => "Choose your level in resistance training (Weightlifting) "
                ],

            ], [
                'id'    => 4,
                'ar' => [
                    'question_content'   => "هل تريد أن تحصل على ؟"
                ],
                'en' => [
                    'question_content'   => "Do you want to gain ? "
                ],

            ], [
                'id'    => 5,
                'ar' => [
                    'question_content'   => "هل تريد أن تخسر ؟"
                ],
                'en' => [
                    'question_content'   => "Do you want to lose ? "
                ],

            ],


            [
                'id'    => 6,
                'ar' => [
                    'question_content'   => "هذه الكمية المتوازنة من المغذيات الكلية ، هل تريد إنشاء كمية المغذيات الكلية الخاصة بك؟"
                ],
                'en' => [
                    'question_content'   => "This is a balanced macroNutrients amount, Do you want create your own macroNutrients amount? "
                ],

            ], [
                'id'    => 7,
                'ar' => [
                    'question_content'   => " هل تريد نسبة الدهون في الجسم أكثر تفصيلاً بناءً على محيط الخصر والرقبة والورك؟ "
                ],
                'en' => [
                    'question_content'   => " Do you want more detailed body fat percentage based on waist-neck-hip circumference ? "
                ],

            ],
        ];
        foreach ($questions as $question) {
            Question::create($question);
        }
    }
}
