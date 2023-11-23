<?php

namespace Tests\Feature\Dashboard\Controllers\Nutrition;

use App\Models\MealType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MealTypeTest extends TestCase
{
    use RefreshDatabase;
    private $baseUrl = '/manager/nutrition/meal-types';

    public function test_mealTypes_index_page_return_success()
    {
        $this->withoutExceptionHandling();
        $mealType = MealType::create([
            [
                'id'    => 1,
                'ar' => [
                    'title'   => "وجبة الفطار"
                ],
                'en' => [
                    'title'   => "Break Fast"
                ],
            ],
        ]);
        $response = $this->actingAs($this->manager)->get($this->baseUrl);
        $response->assertOk();
        $response->assertSeeText($mealType->title);
    }

    public function test_meals_index_page_return_404()
    {
        $response = $this->actingAs($this->manager)->get('/manager/nutrition/meal-types1');
        $response->assertNotFound();
    }
}
