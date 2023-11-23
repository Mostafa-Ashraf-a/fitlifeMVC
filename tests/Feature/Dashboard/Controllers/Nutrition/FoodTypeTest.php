<?php

namespace Tests\Feature\Dashboard\Controllers\Nutrition;

use App\Models\FoodType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FoodTypeTest extends TestCase
{
    use RefreshDatabase;
    private $baseUrl = '/manager/nutrition/food-types';
    public function test_food_types_index_page_return_success()
    {
        $this->withoutExceptionHandling();
        $response = $this->actingAs($this->manager)->get($this->baseUrl);
        $response->assertOk();
    }

    public function test_food_types_index_page_return_not_found()
    {
        $response = $this->actingAs($this->manager)->get($this->baseUrl . 'test');
        $response->assertNotFound();
    }

    public function test_food_types_index_page_contains_table_food_types()
    {
        $foodType = FoodType::create([
            [
                'id'    => 1,
                'ar' => [
                    'title'   => "النشويات"
                ],
                'en' => [
                    'title'   => "Starches"
                ],
            ],
        ]);
        $response = $this->actingAs($this->manager)->get($this->baseUrl);
        $response->assertOk();
        $response->assertSeeText($foodType->title);
    }
}
