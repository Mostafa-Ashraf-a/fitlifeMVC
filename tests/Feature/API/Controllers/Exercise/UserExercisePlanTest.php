<?php

namespace Tests\Feature\API\Controllers;

use App\Models\BodyPart;
use App\Models\Day;
use App\Models\Equipment;
use App\Models\Exercise;
use App\Models\Level;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserExercisePlanTest extends TestCase
{
    use RefreshDatabase;
    protected $token;
    public function setUp() : void
    {
        parent::setUp();
        $this->artisan('passport:install');
        $this->token = $this->createToken();
    }

    public function test_create_user_exercise_plan_return_404_status_code_invalid_endpoint_url()
    {
        $this->withoutExceptionHandling();
        $requestBody = [

        ];
        $exercisePlan = $this->withHeaders($this->token)->postJson('/api/v1/customer/user-exercise-plan/invalid', $requestBody);
        $exercisePlan->assertNotFound();
        $exercisePlan->assertJsonStructure([
            "code",
            "error",
            "message",
            "payload"
        ]);
        $this->assertEquals(null,$exercisePlan['payload']);
        $this->assertEquals("Resource Not Found",$exercisePlan['message']);
        $this->assertEquals(true,$exercisePlan['error']);
        $this->assertEquals(404,$exercisePlan['code']);
    }

    public function test_create_user_exercise_plan_return_200_status_code()
    {
        $this->withoutExceptionHandling();
        $equipment = Equipment::create([
            'ar' => [
                'title'   => 'مجموعة الدمبل'
            ],
            'en' => [
                'title'     => 'Dumbbell set'
            ],
        ]);
        $level = Level::create([
            'ar' => [

                'title'       => 'مبتدئ',
                'description' => 'إذا كنت جديدًا في ممارسة التمارين الرياضية بانتظام ، فابدأ بالتمارين التي تجهز العضلات للتحرك بشكل جيد من أجل بناء القوة والذاكرة العضلية. عادة ما يتكون روتين المبتدئين من كثافة منخفضة ، وإصدارات معدلة من التمارين مع القليل من التنوع ، وتدريبات لمدة أقصر. سيضمن لك بناء أساس متين كروتين مبتدئ الحصول على أفضل النتائج على المدى الطويل.'
            ],
            'en' => [
                'title'       => 'Beginners',
                'description' => 'If you are new to working out on a regular basis, begin with exercises that prepare the muscles to move with good form in order to build strength and muscle memory. A beginner’s routine usually consists of a low intensity, modified versions of exercises with little variety, and shorter duration workouts. Building a solid foundation as a beginner routine will insure you to get the best results in the long run.'
            ]
        ]);
        $bodyPart = [
            [

                'ar' => [
                    'title'   => "الأكتاف"
                ],
                'en' => [
                    'title'   => "Shoulders"
                ],
            ]
        ];

        BodyPart::create($bodyPart);

        $bodyPartList = BodyPart::all();

        $exercise = [
            'title_en'           => 'push-ups',
            'title_ar'           => 'الضغط',
            'instruction_en'     => 'push-ips instruction',
            'instruction_ar'     => 'الضغط',
            'tip_en'             => 'push ups tips',
            'tip_ar'             => 'الضغط',
            'equipment_id'       => $equipment->id,
            'level_id'           => $level->id,
            'place'              => 1,
            'exercise_category'  => 1,
            'body_part_id'       => $bodyPartList[0]['id']
        ];
        $response =  $this->actingAs($this->manager)->post('manager/exercises', $exercise);
        $response->assertStatus(302);
        $lastExercise = Exercise::query()
            ->with('level','equipment')
            ->withTranslation()->latest()->first();
        $this->assertEquals($exercise['equipment_id'], $lastExercise->equipment_id);
        $this->assertEquals($exercise['title_en'], $lastExercise->title);

        $exerciseResponse = $this->withHeaders($this->token)->get('/api/v1/customer/exercises');
        $exerciseResponse->assertOk();
        $this->assertNotEquals($exerciseResponse['payload'],[]);

        $days = [
            [
                'id'     => 1,
                'value'  => 'Day One',
                'day'    => 1,
            ],
            [
                'id'     => 2,
                'value'  => 'Day Two',
                'day'    => 2,
            ],
            [
                'id'     => 3,
                'value'  => 'Day Three',
                'day'    => 3,
            ],
            [
                'id'     => 4,
                'value'  => 'Day Four',
                'day'    => 4,
            ],
            [
                'id'     => 5,
                'value'  => 'Day Five',
                'day'    => 5,
            ],
            [
                'id'     => 6,
                'value'  => 'Day Six',
                'day'    => 6,
            ],
            [
                'id'     => 7,
                'value'  => 'Day Seven',
                'day'    => 7,
            ],
        ];
        foreach($days as $day){
            Day::create($day);
        }
        $dayModel = Day::first();
        $requestBody = [
            'day'          => $dayModel->day,
            'exercises'    => json_decode('[{"exercise_id": '.$lastExercise->id.'}]', true)
        ];
        $exercisePlan = $this->withHeaders($this->token)->postJson('/api/v1/customer/user-exercise-plan', $requestBody);
        $exercisePlan->assertOk();
        $exercisePlan->assertJsonStructure([
            "code",
            "error",
            "message",
            "payload"
        ]);
        $this->assertEquals(true,$exercisePlan['payload']);
        $this->assertEquals(" ",$exercisePlan['message']);
        $this->assertEquals(false,$exercisePlan['error']);
        $this->assertEquals(200,$exercisePlan['code']);
    }


//    public function test_create_user_exercise_plan_return_400_status_code_when_adding_same_exercise_with_same_day()
//    {
//        $this->withoutExceptionHandling();
//        $equipment = Equipment::create([
//            'ar' => [
//                'title'   => 'مجموعة الدمبل'
//            ],
//            'en' => [
//                'title'     => 'Dumbbell set'
//            ],
//        ]);
//        $level = Level::create([
//            'ar' => [
//
//                'title'       => 'مبتدئ',
//                'description' => 'إذا كنت جديدًا في ممارسة التمارين الرياضية بانتظام ، فابدأ بالتمارين التي تجهز العضلات للتحرك بشكل جيد من أجل بناء القوة والذاكرة العضلية. عادة ما يتكون روتين المبتدئين من كثافة منخفضة ، وإصدارات معدلة من التمارين مع القليل من التنوع ، وتدريبات لمدة أقصر. سيضمن لك بناء أساس متين كروتين مبتدئ الحصول على أفضل النتائج على المدى الطويل.'
//            ],
//            'en' => [
//                'title'       => 'Beginners',
//                'description' => 'If you are new to working out on a regular basis, begin with exercises that prepare the muscles to move with good form in order to build strength and muscle memory. A beginner’s routine usually consists of a low intensity, modified versions of exercises with little variety, and shorter duration workouts. Building a solid foundation as a beginner routine will insure you to get the best results in the long run.'
//            ]
//        ]);
//        $bodyPart = [
//            [
//
//                'ar' => [
//                    'title'   => "الأكتاف"
//                ],
//                'en' => [
//                    'title'   => "Shoulders"
//                ],
//            ]
//        ];
//
//        BodyPart::create($bodyPart);
//
//        $bodyPartList = BodyPart::all();
//
//        $exercise = [
//            'title_en'           => 'push-ups',
//            'title_ar'           => 'الضغط',
//            'instruction_en'     => 'push-ips instruction',
//            'instruction_ar'     => 'الضغط',
//            'tip_en'             => 'push ups tips',
//            'tip_ar'             => 'الضغط',
//            'equipment_id'       => $equipment->id,
//            'level_id'           => $level->id,
//            'place'              => 1,
//            'exercise_category'  => 1,
//            'body_part_id'       => $bodyPartList[0]['id']
//        ];
//        $response =  $this->actingAs($this->manager)->post('manager/exercises', $exercise);
//        $response->assertStatus(302);
//        $lastExercise = Exercise::query()
//            ->with('level','equipment')
//            ->withTranslation()->latest()->first();
//        $this->assertEquals($exercise['equipment_id'], $lastExercise->equipment_id);
//        $this->assertEquals($exercise['title_en'], $lastExercise->title);
//
//        $exerciseResponse = $this->withHeaders($this->token)->get('/api/v1/customer/exercises');
//        $exerciseResponse->assertOk();
//        $this->assertNotEquals($exerciseResponse['payload'],[]);
//
//        $dayModel = Day::create([
//            'value' => "Day One",
//            'day'   => 1
//        ]);
//        // test exercise plan
//        $requestBody = [
//            'day'          => $dayModel->id,
//            'exercises'    => json_decode('[{"exercise_id": '.$lastExercise->id.'}]', true)
//        ];
//        $exercisePlan = $this->withHeaders($this->token)->postJson('/api/v1/customer/user-exercise-plan', $requestBody);
//        $exercisePlan->assertStatus(200);
//        $exercisePlan->assertJsonStructure([
//            "code",
//            "error",
//            "message",
//            "payload"
//        ]);
//        $this->assertEquals(true,$exercisePlan['payload']);
//        $this->assertEquals(" ",$exercisePlan['message']);
//        $this->assertEquals(false,$exercisePlan['error']);
//        $this->assertEquals(200,$exercisePlan['code']);
//
//        $exercisePlan = $this->withHeaders($this->token)->postJson('/api/v1/customer/user-exercise-plan', $requestBody);
//        $exercisePlan->assertStatus(400);
//        $exercisePlan->assertJsonStructure([
//            "code",
//            "error",
//            "message",
//            "payload"
//        ]);
//        $this->assertEquals(null,$exercisePlan['payload']);
//        $this->assertEquals("The plan Is already added",$exercisePlan['message']);
//        $this->assertEquals(true,$exercisePlan['error']);
//        $this->assertEquals(400,$exercisePlan['code']);
//    }

    public function test_create_user_exercise_plan_return_422_status_code_when_passing_invalid_exercise()
    {
        $this->withoutExceptionHandling();
        $equipment = Equipment::create([
            'ar' => [
                'title'   => 'مجموعة الدمبل'
            ],
            'en' => [
                'title'     => 'Dumbbell set'
            ],
        ]);
        $level = Level::create([
            'ar' => [

                'title'       => 'مبتدئ',
                'description' => 'إذا كنت جديدًا في ممارسة التمارين الرياضية بانتظام ، فابدأ بالتمارين التي تجهز العضلات للتحرك بشكل جيد من أجل بناء القوة والذاكرة العضلية. عادة ما يتكون روتين المبتدئين من كثافة منخفضة ، وإصدارات معدلة من التمارين مع القليل من التنوع ، وتدريبات لمدة أقصر. سيضمن لك بناء أساس متين كروتين مبتدئ الحصول على أفضل النتائج على المدى الطويل.'
            ],
            'en' => [
                'title'       => 'Beginners',
                'description' => 'If you are new to working out on a regular basis, begin with exercises that prepare the muscles to move with good form in order to build strength and muscle memory. A beginner’s routine usually consists of a low intensity, modified versions of exercises with little variety, and shorter duration workouts. Building a solid foundation as a beginner routine will insure you to get the best results in the long run.'
            ]
        ]);
        $bodyPart = [
            [

                'ar' => [
                    'title'   => "الأكتاف"
                ],
                'en' => [
                    'title'   => "Shoulders"
                ],
            ]
        ];

        BodyPart::create($bodyPart);

        $bodyPartList = BodyPart::all();

        $exercise = [
            'title_en'           => 'push-ups',
            'title_ar'           => 'الضغط',
            'instruction_en'     => 'push-ips instruction',
            'instruction_ar'     => 'الضغط',
            'tip_en'             => 'push ups tips',
            'tip_ar'             => 'الضغط',
            'equipment_id'       => $equipment->id,
            'level_id'           => $level->id,
            'place'              => 1,
            'exercise_category'  => 1,
            'body_part_id'       => $bodyPartList[0]['id']
        ];
        $response =  $this->actingAs($this->manager)->post('manager/exercises', $exercise);
        $response->assertStatus(302);
        $lastExercise = Exercise::query()
            ->with('level','equipment')
            ->withTranslation()->latest()->first();

        $this->assertEquals($exercise['equipment_id'], $lastExercise->equipment_id);
        $this->assertEquals($exercise['title_en'], $lastExercise->title);

        $exerciseResponse = $this->withHeaders($this->token)->get('/api/v1/customer/exercises');
        $exerciseResponse->assertOk();

        $this->assertNotEquals($exerciseResponse['payload'],[]);

        $days = [
            [
                'id'     => 1,
                'value'  => 'Day One',
                'day'    => 1,
            ],
            [
                'id'     => 2,
                'value'  => 'Day Two',
                'day'    => 2,
            ],
            [
                'id'     => 3,
                'value'  => 'Day Three',
                'day'    => 3,
            ],
            [
                'id'     => 4,
                'value'  => 'Day Four',
                'day'    => 4,
            ],
            [
                'id'     => 5,
                'value'  => 'Day Five',
                'day'    => 5,
            ],
            [
                'id'     => 6,
                'value'  => 'Day Six',
                'day'    => 6,
            ],
            [
                'id'     => 7,
                'value'  => 'Day Seven',
                'day'    => 7,
            ],
        ];
        foreach($days as $day){
            Day::create($day);
        }
        $dayModel = Day::first();

        $requestBody = [
            'day'          => $dayModel->day,
            'exercises'    => json_decode('[{"exercise_id": 10}]', true)
        ];
        $exercisePlan = $this->withHeaders($this->token)->postJson('/api/v1/customer/user-exercise-plan', $requestBody);
        $exercisePlan->assertNotFound();
        $exercisePlan->assertJsonStructure([
            "code",
            "error",
            "message",
            "payload"
        ]);
        $this->assertEquals(null,$exercisePlan['payload']);
        $this->assertEquals("Exercise Not Found",$exercisePlan['message']);
        $this->assertEquals(true,$exercisePlan['error']);
        $this->assertEquals(404,$exercisePlan['code']);
    }

}
