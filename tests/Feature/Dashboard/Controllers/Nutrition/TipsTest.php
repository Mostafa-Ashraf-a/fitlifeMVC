<?php

namespace Tests\Feature\Dashboard\Controllers\Nutrition;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TipsTest extends TestCase
{
    use RefreshDatabase;
    private $baseUrl = '/manager/tips';

    public function test_tips_index_page_return_success()
    {
        $this->withoutExceptionHandling();
        $response = $this->actingAs($this->manager)->get($this->baseUrl);
        $response->assertOk();
    }

    public function test_tips_index_page_return_404()
    {
        $response = $this->actingAs($this->manager)->get('/manager/tips1');
        $response->assertNotFound();
    }
}
