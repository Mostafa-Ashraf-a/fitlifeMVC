<?php

namespace Tests\Feature\Dashboard\Controllers\Nutrition;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecipeTest extends TestCase
{
    use RefreshDatabase;
    private $baseUrl = '/manager/nutrition/recipes';

    public function test_recipe_index_page_return_success()
    {
        $this->withoutExceptionHandling();
        $response = $this->actingAs($this->manager)->get($this->baseUrl);
        $response->assertOk();
    }

    public function test_recipe_index_page_return_404()
    {
        $response = $this->actingAs($this->manager)->get('/manager/nutrition/recipes1');
        $response->assertNotFound();
    }
}
