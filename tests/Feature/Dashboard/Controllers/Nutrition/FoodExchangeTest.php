<?php

namespace Tests\Feature\Dashboard\Controllers\Nutrition;

use App\Models\FoodType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FoodExchangeTest extends TestCase
{
    use RefreshDatabase;
    private $baseUrl = '/manager/nutrition/food-exchanges';

    public function test_food_exchanges_index_page_return_success()
    {
        $this->withoutExceptionHandling();
        $response = $this->actingAs($this->manager)->get($this->baseUrl);
        $response->assertOk();
    }

    public function test_invalid_food_exchanges_index_page_url_return_404()
    {
        $response = $this->actingAs($this->manager)->get($this->baseUrl. 'test');
        $response->assertNotFound();
    }

    public function test_food_exchanges_index_page_contains_table_food_exchanges()
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
        $response = $this->actingAs($this->manager)->get('/manager/nutrition/food-types');
        $response->assertOk();
        $response->assertSeeText($foodType->title);

        $model =
            [
                'title_ar'       => 'الخبز والطحين',
                'title_en'       => 'Breads and Flours',
                'food_type_id'   => $foodType->id
            ];
        $foodExchangeResponse = $this->followingRedirects()->actingAs($this->manager)->post($this->baseUrl, $model);
        $foodExchangeResponse->assertStatus(200);

        $foodExchangeList = $this->actingAs($this->manager)->get($this->baseUrl);
        $foodExchangeList->assertOk();
//        $foodExchangeList->assertSeeText($model['title_en']);
    }
}
