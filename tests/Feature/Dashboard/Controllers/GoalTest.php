<?php

namespace Tests\Feature\Dashboard\Controllers;

use App\Models\Goal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GoalTest extends TestCase
{
    use RefreshDatabase;
    public function test_goals_page_return_success()
    {
        $this->withoutExceptionHandling();
        $response = $this->actingAs($this->manager)->get('/manager/exercise/goals');
        $response->assertStatus(200);
    }
}
