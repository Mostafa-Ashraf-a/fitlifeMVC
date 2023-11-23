<?php

namespace Tests\Feature\API\Controllers\Nutrition;

use App\Models\FoodExchange;
use App\Models\FoodType;
use App\Models\Serving;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServingTest extends TestCase
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

    public function test_api_serving_valid_endpoint_url_return_200_status_code()
    {
        $response = $this->withHeaders($this->token)->get($this->baseUrl . 'serving');
        $response->assertOk();
    }
    public function test_api_serving_invalid_endpoint_url_return_404_status_code()
    {
        $response = $this->withHeaders($this->token)->get($this->baseUrl . 'servingTest');
        $response->assertNotFound();
    }
    public function test_api_serving_with_running_plan_return_200_status_code()
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


        $servingResponse = $this->withHeaders($this->token)->get($this->baseUrl . 'serving');
        $servingResponse->assertOk();
        $servingResponse->assertJsonStructure([
            "code",
            "error",
            "message",
            "payload" =>
                [
                "has_running_plan",
                "master" =>
                        [
                            "id",
                            "starches",
                            "fruits",
                            "vegetables",
                            "meats",
                            "dairy",
                            "oils",
                        ],
                    "used" =>
                        [
                            "id",
                            "starches",
                            "fruits",
                            "vegetables",
                            "meats",
                            "dairy",
                            "oils",
                        ],
                    "under_implementation" =>
                        [
                            "id",
                            "starches",
                            "fruits",
                            "vegetables",
                            "meats",
                            "dairy",
                            "oils",
                        ],
                ]
        ]);
        $this->assertEquals($servingResponse['payload']['has_running_plan'], true);
        $this->assertNotEquals($servingResponse['payload']['used'], null);
        $this->assertNotEquals($servingResponse['payload']['under_implementation'], null);
        $this->assertNotEquals($servingResponse['payload']['master'], null);

    }

    public function test_api_serving_when_there_is_no_running_plan_return_200_status_code()
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


        $moveRunningPlanToHistoryResponse = $this->withHeaders($this->token)->postJson($this->baseUrl . 'history-plans');
        $moveRunningPlanToHistoryResponse->assertOk();
        $servingResponse = $this->withHeaders($this->token)->getJson($this->baseUrl . 'serving');
        $servingResponse->assertOk();
        $servingResponse->assertJsonStructure([
            "code",
            "error",
            "message",
            "payload" =>
                [
                    "has_running_plan",
                    "master" =>
                        [
                            "id",
                            "starches",
                            "fruits",
                            "vegetables",
                            "meats",
                            "dairy",
                            "oils",
                        ],
                    "used",
                    "under_implementation",
                ]
        ]);
        $this->assertEquals($servingResponse['payload']['has_running_plan'], false);
        $this->assertEquals($servingResponse['payload']['used'], null);
        $this->assertEquals($servingResponse['payload']['under_implementation'], null);
        $this->assertNotEquals($servingResponse['payload']['master'], null);
    }

    public function test_api_update_serving_with_running_plan_return_422_status_code_when_sending_negative_serving_values()
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
        $types = [
            [
                'id'    => 1,
                'ar' => [
                    'title'   => "النشويات"
                ],
                'en' => [
                    'title'   => "Starches"
                ],
            ],
            [
                'id'    => 2,
                'ar' => [
                    'title'   => "الفواكه"
                ],
                'en' => [
                    'title'   => "Fruits"
                ],
            ], [
                'id'    => 3,
                'ar' => [
                    'title'   => "الخضروات"
                ],
                'en' => [
                    'title'   => "Vegetables"
                ],
            ],[
                'id'    => 4,
                'ar' => [
                    'title'   => "اللحوم"
                ],
                'en' => [
                    'title'   => "Meats"
                ],
            ],[
                'id'    => 5,
                'ar' => [
                    'title'   => "الألبان"
                ],
                'en' => [
                    'title'   => "Dairy"
                ],
            ],[
                'id'    => 6,
                'ar' => [
                    'title'   => "الزيوت"
                ],
                'en' => [
                    'title'   => "Oils"
                ],
            ],
        ];
        foreach($types as $type){
            FoodType::create($type);
        }
        $foodType = FoodType::get();

        $foodExchanges = [
            [
                'id'                  => 1,
                'food_type_id'           => $foodType[0]['id'],
                'ar' => [
                    'title'           => "الخبز والطحين",
                ],
                'en' => [
                    'title'         => "Breads and Flours",
                ],
            ],
            [
                'id'                  => 2,
                'food_type_id'           => $foodType[1]['id'],
                'ar' => [
                    'title'           => "الحبوب والحبوب والمعكرونة",
                ],
                'en' => [
                    'title'         => "Cereals, Grains and Pasta ",
                ],
            ],
            [
                'id'                  => 3,
                'food_type_id'           => $foodType[2]['id'],
                'ar' => [
                    'title'           => "خضروات نشوية",
                ],
                'en' => [
                    'title'         => "Starchy Vegetables",
                ],
            ],
            [
                'id'                  => 4,
                'food_type_id'           => $foodType[3]['id'],
                'ar' => [
                    'title'           => "وجبات خفيفة",
                ],
                'en' => [
                    'title'         => "Snacks",
                ],
            ],
            [
                'id'                  => 5,
                'food_type_id'           => $foodType[4]['id'],
                'ar' => [
                    'title'           => "الفول والبازلاء والعدس (مطبوخ)",
                ],
                'en' => [
                    'title'         => "Beans, Peas and Lentils (Cooked)",
                ],
            ],
            [
                'id'                  => 6,
                'food_type_id'           => $foodType[5]['id'],
                'ar' => [
                    'title'           => "عصير فواكه",
                ],
                'en' => [
                    'title'         => "Fruit Juice",
                ],
            ],
            [
                'id'                  => 7,
                'food_type_id'           => $foodType[1]['id'],
                'ar' => [
                    'title'           => "عصير ليمون",
                ],
                'en' => [
                    'title'         => "Lemon juice",
                ],
            ],
            [
                'id'                  => 8,
                'food_type_id'           => $foodType[1]['id'],
                'ar' => [
                    'title'           => "عصير برتقال",
                ],
                'en' => [
                    'title'         => "orange juice",
                ],
            ],
            [
                'id'                  => 9,
                'food_type_id'           => $foodType[3]['id'],
                'ar' => [
                    'title'           => "شريحة لحم البقر",
                ],
                'en' => [
                    'title'         => "beef steak",
                ],
            ],
            [
                'id'                  => 10,
                'food_type_id'           => $foodType[3]['id'],
                'ar' => [
                    'title'           => "السمك المدخن",
                ],
                'en' => [
                    'title'         => "smoked fish",
                ],
            ],
        ];
        foreach($foodExchanges as $foodExchange){
            FoodExchange::create($foodExchange);
        }
        $foodExchangeList = FoodExchange::get();

        $meal = [
            'title'               => 'test meal',
            'foodExchanges'       => json_decode('[{"food_exchange_id": '.$foodExchangeList[0]['id'].', "quantity" :3},{"food_exchange_id": '.$foodExchangeList[1]['id'].', "quantity" :4},{"food_exchange_id": '.$foodExchangeList[2]['id'].', "quantity" :3},{"food_exchange_id": '.$foodExchangeList[3]['id'].', "quantity" :2}]', true)
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


        $servingResponse = $this->withHeaders($this->token)->get($this->baseUrl . 'serving');
        $servingResponse->assertOk();
        $servingResponse->assertJsonStructure([
            "code",
            "error",
            "message",
            "payload" =>
                [
                    "has_running_plan",
                    "master" =>
                        [
                            "id",
                            "starches",
                            "fruits",
                            "vegetables",
                            "meats",
                            "dairy",
                            "oils",
                        ],
                    "used" =>
                        [
                            "id",
                            "starches",
                            "fruits",
                            "vegetables",
                            "meats",
                            "dairy",
                            "oils",
                        ],
                    "under_implementation" =>
                        [
                            "id",
                            "starches",
                            "fruits",
                            "vegetables",
                            "meats",
                            "dairy",
                            "oils",
                        ],
                ]
        ]);
        $this->assertEquals($servingResponse['payload']['has_running_plan'], true);
        $this->assertNotEquals($servingResponse['payload']['used'], null);
        $this->assertNotEquals($servingResponse['payload']['under_implementation'], null);
        $this->assertNotEquals($servingResponse['payload']['master'], null);

        $servingUnderImplementationValues = [
            "starches"   => -1,
            "fruits"     => -1,
            "vegetables" => -1,
            "meats"      => -1,
            "dairy"      => -1,
            "oils"       => -1
        ];
        $servingResponse = $this->withHeaders($this->token)->putJson($this->baseUrl . 'serving/' . $servingResponse['payload']['under_implementation']['id'], $servingUnderImplementationValues);
        $servingResponse->assertUnprocessable();

    }


    public function test_api_update_serving_with_running_plan_return_403_status_code_when_sending_incorrect_or_not_under_implementing_serving_id()
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
        $types = [
            [
                'id'    => 1,
                'ar' => [
                    'title'   => "النشويات"
                ],
                'en' => [
                    'title'   => "Starches"
                ],
            ],
            [
                'id'    => 2,
                'ar' => [
                    'title'   => "الفواكه"
                ],
                'en' => [
                    'title'   => "Fruits"
                ],
            ], [
                'id'    => 3,
                'ar' => [
                    'title'   => "الخضروات"
                ],
                'en' => [
                    'title'   => "Vegetables"
                ],
            ],[
                'id'    => 4,
                'ar' => [
                    'title'   => "اللحوم"
                ],
                'en' => [
                    'title'   => "Meats"
                ],
            ],[
                'id'    => 5,
                'ar' => [
                    'title'   => "الألبان"
                ],
                'en' => [
                    'title'   => "Dairy"
                ],
            ],[
                'id'    => 6,
                'ar' => [
                    'title'   => "الزيوت"
                ],
                'en' => [
                    'title'   => "Oils"
                ],
            ],
        ];
        foreach($types as $type){
            FoodType::create($type);
        }
        $foodType = FoodType::get();

        $foodExchanges = [
            [
                'id'                  => 1,
                'food_type_id'           => $foodType[0]['id'],
                'ar' => [
                    'title'           => "الخبز والطحين",
                ],
                'en' => [
                    'title'         => "Breads and Flours",
                ],
            ],
            [
                'id'                  => 2,
                'food_type_id'           => $foodType[1]['id'],
                'ar' => [
                    'title'           => "الحبوب والحبوب والمعكرونة",
                ],
                'en' => [
                    'title'         => "Cereals, Grains and Pasta ",
                ],
            ],
            [
                'id'                  => 3,
                'food_type_id'           => $foodType[2]['id'],
                'ar' => [
                    'title'           => "خضروات نشوية",
                ],
                'en' => [
                    'title'         => "Starchy Vegetables",
                ],
            ],
            [
                'id'                  => 4,
                'food_type_id'           => $foodType[3]['id'],
                'ar' => [
                    'title'           => "وجبات خفيفة",
                ],
                'en' => [
                    'title'         => "Snacks",
                ],
            ],
            [
                'id'                  => 5,
                'food_type_id'           => $foodType[4]['id'],
                'ar' => [
                    'title'           => "الفول والبازلاء والعدس (مطبوخ)",
                ],
                'en' => [
                    'title'         => "Beans, Peas and Lentils (Cooked)",
                ],
            ],
            [
                'id'                  => 6,
                'food_type_id'           => $foodType[5]['id'],
                'ar' => [
                    'title'           => "عصير فواكه",
                ],
                'en' => [
                    'title'         => "Fruit Juice",
                ],
            ],
            [
                'id'                  => 7,
                'food_type_id'           => $foodType[1]['id'],
                'ar' => [
                    'title'           => "عصير ليمون",
                ],
                'en' => [
                    'title'         => "Lemon juice",
                ],
            ],
            [
                'id'                  => 8,
                'food_type_id'           => $foodType[1]['id'],
                'ar' => [
                    'title'           => "عصير برتقال",
                ],
                'en' => [
                    'title'         => "orange juice",
                ],
            ],
            [
                'id'                  => 9,
                'food_type_id'           => $foodType[3]['id'],
                'ar' => [
                    'title'           => "شريحة لحم البقر",
                ],
                'en' => [
                    'title'         => "beef steak",
                ],
            ],
            [
                'id'                  => 10,
                'food_type_id'           => $foodType[3]['id'],
                'ar' => [
                    'title'           => "السمك المدخن",
                ],
                'en' => [
                    'title'         => "smoked fish",
                ],
            ],
        ];
        foreach($foodExchanges as $foodExchange){
            FoodExchange::create($foodExchange);
        }
        $foodExchangeList = FoodExchange::get();

        $meal = [
            'title'               => 'test meal',
            'foodExchanges'       => json_decode('[{"food_exchange_id": '.$foodExchangeList[0]['id'].', "quantity" :3},{"food_exchange_id": '.$foodExchangeList[1]['id'].', "quantity" :4},{"food_exchange_id": '.$foodExchangeList[2]['id'].', "quantity" :3},{"food_exchange_id": '.$foodExchangeList[3]['id'].', "quantity" :2}]', true)
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


        $servingResponse = $this->withHeaders($this->token)->get($this->baseUrl . 'serving');
        $servingResponse->assertOk();
        $servingResponse->assertJsonStructure([
            "code",
            "error",
            "message",
            "payload" =>
                [
                    "has_running_plan",
                    "master" =>
                        [
                            "id",
                            "starches",
                            "fruits",
                            "vegetables",
                            "meats",
                            "dairy",
                            "oils",
                        ],
                    "used" =>
                        [
                            "id",
                            "starches",
                            "fruits",
                            "vegetables",
                            "meats",
                            "dairy",
                            "oils",
                        ],
                    "under_implementation" =>
                        [
                            "id",
                            "starches",
                            "fruits",
                            "vegetables",
                            "meats",
                            "dairy",
                            "oils",
                        ],
                ]
        ]);
        $this->assertEquals($servingResponse['payload']['has_running_plan'], true);
        $this->assertNotEquals($servingResponse['payload']['used'], null);
        $this->assertNotEquals($servingResponse['payload']['under_implementation'], null);
        $this->assertNotEquals($servingResponse['payload']['master'], null);

        $servingUnderImplementationValues = [
            "starches"   => 0,
            "fruits"     => 0,
            "vegetables" => 0,
            "meats"      => 0,
            "dairy"      => 0,
            "oils"       => 0
        ];
        $servingResponse = $this->withHeaders($this->token)->putJson($this->baseUrl . 'serving/' . $servingResponse['payload']['used']['id'], $servingUnderImplementationValues);
        $servingResponse->assertForbidden();

    }

}
