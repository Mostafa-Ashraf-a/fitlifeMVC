<?php

namespace Tests\Feature\API\Controllers\Nutrition;

use App\Models\FoodExchange;
use App\Models\FoodType;
use App\Models\Serving;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MealTest extends TestCase
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

    public function test_api_create_new_meal_plan_valid_endpoint_url_return_created_with_status_code_201_with_response()
    {
        Serving::create([
            'user_id'     => $this->user['id'],
            'plan_status' => 0,
            'status'      => 1,
            'starches'    => 9,
            'fruits'      => 8,
            'vegetables'  => 7,
            'meats'       => 6,
            'dairy'       => 5,
            'oils'        => 10,
        ]);
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
        $model =
            [
                'title_ar'       => 'الخبز والطحين',
                'title_en'       => 'Breads and Flours',
                'food_type_id'   => $foodType->id
            ];
        $foodExchangeResponse = $this->followingRedirects()->actingAs($this->manager)->post('/manager/nutrition/food-exchanges', $model);
        $foodExchangeResponse->assertStatus(200);
        $foodExchangeList = FoodExchange::get();

        $meal = [
            'title'               => 'test meal',
            'foodExchanges'       => json_decode('[{"food_exchange_id": '.$foodExchangeList[0]['id'].', "quantity" : 1}]', true)
        ];
        $response = $this->withHeaders($this->token)->postJson($this->baseUrl . 'meals', $meal);
        $response->assertCreated();
        $response->assertJsonStructure([
            "code",
            "error",
            "message",
            "payload" =>
            [
                [
                "id",
                "title",
                "meal" =>
                    [
                        "id",
                        "title",
                        "food_exchanges" => [
                            [
                                "id",
                                "title",
                                "image",
                                "quantity",
                                "food_type" => [],
                                "measurement_units" => []
                            ]
                        ]
                    ]
                ]
            ]
        ]);
        $this->assertEquals($response['message'], __('api.meal_plan_created_successfully'));
        $this->assertEquals($response['error'], false);
        $this->assertEquals($response['code'], 201);
    }

    public function test_api_create_new_meal_plan_return_400_bad_request_when_logged_in_user_have_running_plan()
    {
        Serving::create([
            'user_id'     => $this->user['id'],
            'plan_status' => 0,
            'status'      => 1,
            'starches'    => 9,
            'fruits'      => 8,
            'vegetables'  => 7,
            'meats'       => 6,
            'dairy'       => 5,
            'oils'        => 10,
        ]);
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
        $model =
            [
                'title_ar'       => 'الخبز والطحين',
                'title_en'       => 'Breads and Flours',
                'food_type_id'   => $foodType->id
            ];
        $foodExchangeResponse = $this->followingRedirects()->actingAs($this->manager)->post('/manager/nutrition/food-exchanges', $model);
        $foodExchangeResponse->assertStatus(200);
        $foodExchangeList = FoodExchange::get();
        $meal = [
            'title'               => 'test meal',
            'foodExchanges'       => json_decode('[{"food_exchange_id": '.$foodExchangeList[0]['id'].', "quantity" : 5}]', true)
        ];
        $response = $this->withHeaders($this->token)->postJson($this->baseUrl . 'meals', $meal);
        $response->assertCreated();

        $startPlan = $this->withHeaders($this->token)->postJson($this->baseUrl . 'plans', [
            'name'  => "test plan 1"
        ]);
        $startPlan->assertCreated();

        $newResponse = $this->withHeaders($this->token)->postJson($this->baseUrl . 'meals', $meal);
        $newResponse->assertStatus(400);
        $this->assertEquals($newResponse['message'], __('api.you_already_have_a_running_plan'));
        $this->assertEquals($newResponse['error'], true);
        $this->assertEquals($newResponse['payload'], null);
        $this->assertEquals($newResponse['code'], 400);
    }

    public function test_api_create_new_meal_plan_valid_endpoint_url_return_Unprocessable_with_422_status_code()
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
        $model =
            [
                'title_ar'       => 'الخبز والطحين',
                'title_en'       => 'Breads and Flours',
                'food_type_id'   => $foodType->id
            ];
        $foodExchangeResponse = $this->followingRedirects()->actingAs($this->manager)->post('/manager/nutrition/food-exchanges', $model);
        $foodExchangeResponse->assertStatus(200);
        $foodExchangeList = FoodExchange::get();

        $meal = [
            'title_test'          => 'test meal',
            'foodExchanges'       => json_decode('[{"food_exchange_id": '.$foodExchangeList[0]['id'].', "quantity" : 1}]', true)
        ];
        $response = $this->withHeaders($this->token)->postJson($this->baseUrl . 'meals', $meal);
        $response->assertUnprocessable();
    }

    public function test_api_create_new_meal_plan_invalid_endpoint_url_return_404()
    {
        $response = $this->withHeaders($this->token)->post($this->baseUrl . 'mealstest');
        $response->assertNotFound();
    }

    public function test_api_list_meals_not_empty_valid_endpoint_url_return_200_status_code_with_response()
    {
        Serving::create([
            'user_id'     => $this->user['id'],
            'plan_status' => 0,
            'status'      => 1,
            'starches'    => 9,
            'fruits'      => 8,
            'vegetables'  => 7,
            'meats'       => 6,
            'dairy'       => 5,
            'oils'        => 10,
        ]);
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
        $model =
            [
                'title_ar'       => 'الخبز والطحين',
                'title_en'       => 'Breads and Flours',
                'food_type_id'   => $foodType->id
            ];
        $foodExchangeResponse = $this->followingRedirects()->actingAs($this->manager)->post('/manager/nutrition/food-exchanges', $model);
        $foodExchangeResponse->assertStatus(200);
        $foodExchangeList = FoodExchange::get();

        $meal = [
            'title'               => 'test meal',
            'foodExchanges'       => json_decode('[{"food_exchange_id": '.$foodExchangeList[0]['id'].', "quantity" : 1}]', true)
        ];
        $response = $this->withHeaders($this->token)->postJson($this->baseUrl . 'meals', $meal);
        $response->assertCreated();
        $response->assertJsonStructure([
            "code",
            "error",
            "message",
            "payload" =>
                [
                    [
                        "id",
                        "title",
                        "meal" =>
                            [
                                "id",
                                "title",
                                "food_exchanges" => [
                                    [
                                        "id",
                                        "title",
                                        "image",
                                        "quantity",
                                        "food_type" => [],
                                        "measurement_units" => []
                                    ]
                                ]
                            ]
                    ]
                ]
        ]);
        $this->assertEquals($response['message'], __('api.meal_plan_created_successfully'));
        $this->assertEquals($response['error'], false);
        $this->assertEquals($response['code'], 201);

        $listResponse = $this->withHeaders($this->token)->getJson($this->baseUrl . 'meals');
        $listResponse->assertOk();
        $listResponse->assertJsonStructure([
            "code",
            "error",
            "message",
            "payload" =>
                [
                    [
                        "id",
                        "title",
                        "meal" =>
                            [
                                "id",
                                "title",
                                "food_exchanges" => [
                                    [
                                        "id",
                                        "title",
                                        "image",
                                        "quantity",
                                        "food_type" => [],
                                        "measurement_units" => []
                                    ]
                                ]
                            ]
                    ]
                ]
        ]);
        $this->assertEquals($listResponse['message'], " ");
        $this->assertEquals($listResponse['error'], false);
        $this->assertEquals($listResponse['code'], 200);
    }

    public function test_api_list_empty_meals_valid_endpoint_url_return_200_status_code_with_response()
    {
        $listResponse = $this->withHeaders($this->token)->getJson($this->baseUrl . 'meals');
        $listResponse->assertOk();
        $this->assertEquals($listResponse['message'], __('api.You_do_not_have_any_plan_under_construction'));
        $this->assertEquals($listResponse['payload'], null);
        $this->assertEquals($listResponse['error'], false);
        $this->assertEquals($listResponse['code'], 200);
    }
}
