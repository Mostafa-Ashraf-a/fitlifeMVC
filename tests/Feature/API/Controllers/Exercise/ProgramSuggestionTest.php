<?php

namespace Tests\Feature\API\Controllers\Exercise;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProgramSuggestionTest extends TestCase
{
    use RefreshDatabase;
    protected $token;
    private $baseUrl = '/api/v1/customer/exercise/';

    public function setUp() : void
    {
        parent::setUp();
        $this->artisan('passport:install');
        $this->token = $this->createToken();
    }

    public function test_api_exercise_program_suggestions_index_valid_endpoint_url_return_200()
    {
        $response = $this->withHeaders($this->token)->get($this->baseUrl . 'program-suggestions?duration=1');
        $response->assertOk();
    }
    public function test_api_exercise_program_suggestions_index_without_sent_duration_type_return_400()
    {
        $response = $this->withHeaders($this->token)->get($this->baseUrl . 'program-suggestions');
        $response->assertStatus(400);
    }
    public function test_api_exercise_program_suggestions_index_invalid_endpoint_url_return_404()
    {
        $response = $this->withHeaders($this->token)->get($this->baseUrl . 'program-suggestions1');
        $response->assertNotFound();
    }
}
