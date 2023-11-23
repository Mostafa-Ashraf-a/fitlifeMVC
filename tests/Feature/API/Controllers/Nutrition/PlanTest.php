<?php

namespace Tests\Feature\API\Controllers\Nutrition;

use App\Models\FoodExchange;
use App\Models\FoodType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanTest extends TestCase
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

    public function test_api_start_plan_valid_endpoint_url_return_201_status_code()
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
            'title'               => 'test meal',
            'foodExchanges'       => json_decode('[{"food_exchange_id": '.$foodExchangeList[0]['id'].', "quantity" : 1}]', true)
        ];
        $response = $this->withHeaders($this->token)->postJson($this->baseUrl . 'meals', $meal);
        $response->assertCreated();
        $response->assertJsonStructure([
            "code",
            "error",
            "message",
            "payload"
        ]);
        $this->assertEquals($response['message'], __('api.meal_plan_created_successfully'));
        $this->assertEquals($response['error'], false);
        $this->assertEquals($response['code'], 201);

        $plan = [
          'name'  => 'First Plan'
        ];
        $startPlanResponse = $this->withHeaders($this->token)->postJson($this->baseUrl . 'plans', $plan);
        $startPlanResponse->assertCreated();
        $startPlanResponse->assertJsonStructure([
            "code",
            "error",
            "message",
            "payload" => [
                "id",
                "title",
                "meals" => [
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
        $this->assertEquals($startPlanResponse['message'], __('api.the_plan_has_been_successfully_launched'));
        $this->assertEquals($startPlanResponse['error'], false);
        $this->assertEquals($plan['name'], $startPlanResponse['payload']['title']);
        $this->assertEquals($startPlanResponse['code'], 201);
    }

    public function test_api_get_running_plan_valid_endpoint_url_return_200_status_code_with_plan_response()
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
            'title'               => 'test meal',
            'foodExchanges'       => json_decode('[{"food_exchange_id": '.$foodExchangeList[0]['id'].', "quantity" : 1}]', true)
        ];
        $response = $this->withHeaders($this->token)->postJson($this->baseUrl . 'meals', $meal);
        $response->assertCreated();
        $response->assertJsonStructure([
            "code",
            "error",
            "message",
            "payload"
        ]);
        $this->assertEquals($response['message'], __('api.meal_plan_created_successfully'));
        $this->assertEquals($response['error'], false);
        $this->assertEquals($response['code'], 201);

        $plan = [
            'name'  => 'First Plan'
        ];
        $startPlanResponse = $this->withHeaders($this->token)->postJson($this->baseUrl . 'plans', $plan);
        $startPlanResponse->assertCreated();
        $startPlanResponse->assertJsonStructure([
            "code",
            "error",
            "message",
            "payload" => [
                "id",
                "title",
                "meals" => [
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
        $this->assertEquals($startPlanResponse['message'], __('api.the_plan_has_been_successfully_launched'));
        $this->assertEquals($startPlanResponse['error'], false);
        $this->assertEquals($plan['name'], $startPlanResponse['payload']['title']);
        $this->assertEquals($startPlanResponse['code'], 201);



        $runningPlanResponse = $this->withHeaders($this->token)->getJson($this->baseUrl . 'plans', $plan);
        $runningPlanResponse->assertOk();
        $runningPlanResponse->assertJsonStructure([
            "code",
            "error",
            "message",
            "payload" => [
                "id",
                "title",
                "meals" => [
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
        $this->assertEquals($runningPlanResponse['message'], " ");
        $this->assertEquals($runningPlanResponse['error'], false);
        $this->assertEquals($plan['name'], $runningPlanResponse['payload']['title']);
        $this->assertEquals($runningPlanResponse['code'], 200);
    }

    public function test_api_update_running_plan_valid_endpoint_url_return_200_status_code_with_plan_response()
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
            'title'               => 'test meal',
            'foodExchanges'       => json_decode('[{"food_exchange_id": '.$foodExchangeList[0]['id'].', "quantity" : 1}]', true)
        ];
        $response = $this->withHeaders($this->token)->postJson($this->baseUrl . 'meals', $meal);
        $response->assertCreated();
        $response->assertJsonStructure([
            "code",
            "error",
            "message",
            "payload"
        ]);
        $this->assertEquals($response['message'], __('api.meal_plan_created_successfully'));
        $this->assertEquals($response['error'], false);
        $this->assertEquals($response['code'], 201);

        $plan = [
            'name'  => 'First Plan'
        ];
        $startPlanResponse = $this->withHeaders($this->token)->postJson($this->baseUrl . 'plans', $plan);
        $startPlanResponse->assertCreated();
        $startPlanResponse->assertJsonStructure([
            "code",
            "error",
            "message",
            "payload" => [
                "id",
                "title",
                "meals" => [
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
        $this->assertEquals($startPlanResponse['message'], __('api.the_plan_has_been_successfully_launched'));
        $this->assertEquals($startPlanResponse['error'], false);
        $this->assertEquals($plan['name'], $startPlanResponse['payload']['title']);
        $this->assertEquals($startPlanResponse['code'], 201);


        $newPlanName = [
          'name'  => "New Plan Name"
        ];
        $updateRunningPlanResponse = $this->withHeaders($this->token)->putJson($this->baseUrl . 'plans/'. $startPlanResponse['payload']['id'], $newPlanName);
        $updateRunningPlanResponse->assertOk();
        $updateRunningPlanResponse->assertJsonStructure([
            "code",
            "error",
            "message",
            "payload" => [
                "id",
                "title",
                "meals" => [
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
        $this->assertEquals($updateRunningPlanResponse['message'], __('api.meal_plan_updated_successfully'));
        $this->assertEquals($updateRunningPlanResponse['error'], false);
        $this->assertEquals($newPlanName['name'], $updateRunningPlanResponse['payload']['title']);
        $this->assertEquals($updateRunningPlanResponse['code'], 200);
    }

    public function test_api_get_single_plan_details_valid_endpoint_url_return_404_status_code()
    {
        $response = $this->withHeaders($this->token)->get($this->baseUrl . 'plans/1',);
        $response->assertNotFound();

        $response->assertJsonStructure([
            "code",
            "error",
            "message",
            "payload"
        ]);
        $this->assertEquals($response['message'], "Resource Not Found");
        $this->assertEquals($response['error'], true);
        $this->assertEquals($response['code'], 404);
    }

}
