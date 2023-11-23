<?php

namespace Tests\Feature\Dashboard\Controllers;

use App\Models\BodyPart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BodyPartTest extends TestCase
{
    use RefreshDatabase;
    public function test_bodyParts_page_return_success()
    {
        $this->withoutExceptionHandling();
        $response = $this->actingAs($this->manager)->get('/manager/body-parts');
        $response->assertStatus(200);
    }
    public function test_create_new_bodyPart_without_files_successful()
    {
        $this->withoutExceptionHandling();
        $types = [
            [
                'id'    => 1,
                'ar' => [
                    'title'   => "الأكتاف"
                ],
                'en' => [
                    'title'   => "Shoulders"
                ],
            ],
            [
                'id'    => 2,
                'ar' => [
                    'title'   => "الصدر"
                ],
                'en' => [
                    'title'   => "Chest"
                ],
            ],[
                'id'    => 3,
                'ar' => [
                    'title'   => "الأفخاذ الأمامية"
                ],
                'en' => [
                    'title'   => "Quads"
                ],
            ],[
                'id'    => 4,
                'ar' => [
                    'title'   => "بايسبس"
                ],
                'en' => [
                    'title'   => "Biceps"
                ],
            ],[
                'id'    => 5,
                'ar' => [
                    'title'   => "البطن"
                ],
                'en' => [
                    'title'   => "Abs"
                ],
            ],[
                'id'    => 6,
                'ar' => [
                    'title'   => "البطن الجانبية"
                ],
                'en' => [
                    'title'   => "Obliques"
                ],
            ],[
                'id'    => 7,
                'ar' => [
                    'title'   => "السواعد"
                ],
                'en' => [
                    'title'   => "Forearms"
                ],
            ],[
                'id'    => 8,
                'ar' => [
                    'title'   => "الأفخاذ الداخلية"
                ],
                'en' => [
                    'title'   => "Adductors"
                ],
            ],[
                'id'    => 9,
                'ar' => [
                    'title'   => "الترابيس"
                ],
                'en' => [
                    'title'   => "Traps"
                ],
            ],[
                'id'    => 10,
                'ar' => [
                    'title'   => "ترايسبس"
                ],
                'en' => [
                    'title'   => "Triceps"
                ],
            ],[
                'id'    => 11,
                'ar' => [
                    'title'   => "الأفخاد الخلفية"
                ],
                'en' => [
                    'title'   => "Hamstrings"
                ],
            ],[
                'id'    => 12,
                'ar' => [
                    'title'   => "الساق الخلفية"
                ],
                'en' => [
                    'title'   => "Calves"
                ],
            ],[
                'id'    => 13,
                'ar' => [
                    'title'   => "الظهر"
                ],
                'en' => [
                    'title'   => "Back"
                ],
            ],[
                'id'    => 14,
                'ar' => [
                    'title'   => "الأرداف"
                ],
                'en' => [
                    'title'   => "Glutes"
                ],
            ],[
                'id'    => 15,
                'ar' => [
                    'title'   => "الأفخاد الخارجية"
                ],
                'en' => [
                    'title'   => "Abductors"
                ],
            ],
            [
                'id'    => 16,
                'ar' => [
                    'title'   => "كارديو"
                ],
                'en' => [
                    'title'   => "Cardio"
                ],
            ],
        ];
        foreach($types as $type){
            BodyPart::create($type);
        }
        $response =  $this->actingAs($this->manager)->get('manager/body-parts');
        $response->assertStatus(200);
    }
}
