<?php

namespace Tests\Feature\API\Controllers\Nutrition;

use App\Models\FoodType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FoodExchangeTest extends TestCase
{
    use RefreshDatabase;
    protected $token;
    private $baseUrl = '/api/v1/customer/nutrition/';
    public function setUp() : void
    {
        parent::setUp();
        $this->artisan('passport:install');
        $this->token = $this->createToken();
    }
    public function test_api_food_exchanges_index_valid_endpoint_url_return_200()
    {
        $response = $this->withHeaders($this->token)->get($this->baseUrl . 'food-exchanges');
        $response->assertOk();
    }
    public function test_api_food_exchanges_index_invalid_endpoint_url_return_404()
    {
        $response = $this->withHeaders($this->token)->get($this->baseUrl . 'food-exchanges1');
        $response->assertNotFound();
    }

    public function test_api_food_exchanges_index_contains_at_least_one_food_exchange()
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
        $foodExchangeResponse = $this->followingRedirects()->actingAs($this->manager)->post('/manager/nutrition/food-exchanges', $model);
        $foodExchangeResponse->assertStatus(200);
        $this->assertDatabaseHas('food_exchanges',[
           'id' => 1,
            'food_type_id' => $foodType->id
        ]);

        $apiResponse = $this->withHeaders($this->token)->get($this->baseUrl . 'food-exchanges');
        $apiResponse->assertOk();
        $apiResponse->assertJsonStructure([
            "code",
            "error",
            "message",
            "payload"
        ]);
        $this->assertEquals($apiResponse['payload'][0]['title'],$model['title_en']);
    }
}
