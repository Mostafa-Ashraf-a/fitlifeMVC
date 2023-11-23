<?php

namespace Tests\Feature\API\Controllers\Nutrition;

use App\Models\FoodType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FoodTypeTest extends TestCase
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
    public function test_api_food_types_index_valid_endpoint_url_return_200()
    {
        $response = $this->withHeaders($this->token)->get($this->baseUrl . 'food-types');
        $response->assertOk();
    }
    public function test_api_food_types_index_invalid_endpoint_url_return_404()
    {
        $response = $this->withHeaders($this->token)->get($this->baseUrl . 'food-types1');
        $response->assertNotFound();
    }

    public function test_api_food_types_index_contains_at_least_one_food_type()
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
        $response = $this->withHeaders($this->token)->get($this->baseUrl . 'food-types');
        $response->assertOk();
        $response->assertJsonStructure([
            "code",
            "error",
            "message",
            "payload"
        ]);
        $this->assertEquals($response['payload'][0]['id'],$foodType->id);
        $this->assertEquals($response['payload'][0]['title'],$foodType->title);
    }

}
