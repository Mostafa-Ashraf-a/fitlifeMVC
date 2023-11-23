<?php

namespace Tests\Feature\Dashboard\Controllers;

use App\Models\Goal;
use App\Models\Level;
use App\Models\WorkoutType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WorkoutTest extends TestCase
{
    public function test_workouts_page_return_success()
    {
        $this->withoutExceptionHandling();
        $response = $this->actingAs($this->manager)->get('/manager/workouts');
        $response->assertStatus(200);
    }

    public function test_create_new_workout_without_files_successful()
    {
        $this->withoutExceptionHandling();
        Goal::create([
            [
                'id'    => 1,
                'ar' => [
                    'title'   => "زيادة الوزن"
                ],
                'en' => [
                    'title'   => "Gain"
                ],
            ]
        ]);
        Level::create([
                [
                    'id'    => 1,
                    'ar' => [
                        'title'        => "مبتدئ",
                        "description"  => "إذا كنت جديدًا في ممارسة التمارين الرياضية بانتظام ، فابدأ بالتمارين التي تجهز العضلات للتحرك بشكل جيد من أجل بناء القوة والذاكرة العضلية. عادة ما يتكون روتين المبتدئين من كثافة منخفضة ، وإصدارات معدلة من التمارين مع القليل من التنوع ، وتدريبات لمدة أقصر. سيضمن لك بناء أساس متين كروتين مبتدئ الحصول على أفضل النتائج على المدى الطويل."
                    ],
                    'en' => [
                        'title'        => "Beginners",
                        "description"  => "If you are new to working out on a regular basis, begin with exercises that prepare the muscles to move with good form in order to build strength and muscle memory. A beginner’s routine usually consists of a low intensity, modified versions of exercises with little variety, and shorter duration workouts. Building a solid foundation as a beginner routine will insure you to get the best results in the long run."
                    ],
                ],
            ]);
        WorkoutType::create([
            'id'           => 1,
            'value'        => "Type 1",
            'repetition'   => 1
        ]);
        $goals = Goal::all();
        $levels = Level::all();
        $workoutTypes = WorkoutType::all();
        $workout = [
            'title'        => 'test workout 1',
            'description'  => 'test workout description 1',
            'goal_id'      => $goals[0]['id'],  // Gain
            'level_id'     => $levels[0]['id'],  // Beginner
            'place_type'   => 1,  // Gym Exercise
            'type_id'      => $workoutTypes[0]['id'],  // Type 1
            'status'       => 1,
        ];
        $response =  $this->actingAs($this->manager)->post('manager/workouts', $workout);
        $response->assertStatus(302);
    }
}
