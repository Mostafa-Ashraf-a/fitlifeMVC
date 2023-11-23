<?php

namespace Tests\Feature\API\Controllers\Nutrition;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HistoryPlanTest extends TestCase
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

    public function test_history_plans_endpoint_valid_url_return_200_status_code()
    {
        $response = $this->withHeaders($this->token)->getJson($this->baseUrl . 'history-plans');
        $response->assertOk();
    }

    public function test_history_plans_endpoint_invalid_url_return_404_status_code()
    {
        $response = $this->withHeaders($this->token)->getJson($this->baseUrl . 'history-plans-test');
        $response->assertNotFound();
    }

    public function test_history_plans_endpoint_case_there_is_no_records_return_empty_payload_list()
    {
        $response = $this->withHeaders($this->token)->getJson($this->baseUrl . 'history-plans');
        $response->assertOk();
        $response->assertJsonStructure([
            "code",
            "error",
            "message",
            "payload"
        ]);
        $this->assertEquals($response['message'], " ");
        $this->assertEquals($response['error'], false);
        $this->assertEquals($response['payload'], []);
        $this->assertEquals($response['code'], 200);
    }
}
