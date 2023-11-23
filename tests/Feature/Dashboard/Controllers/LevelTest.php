<?php

namespace Tests\Feature\Dashboard\Controllers;

use App\Models\Level;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LevelTest extends TestCase
{
    use RefreshDatabase;
    public function test_levels_page_return_success()
    {
        $this->withoutExceptionHandling();
        $response = $this->actingAs($this->manager)->get('/manager/exercise/levels');
        $response->assertStatus(200);
    }
}
