<?php

namespace Tests\Feature\Dashboard\Controllers;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    public function test_categories_page_return_success()
    {
        $this->withoutExceptionHandling();
        $response = $this->actingAs($this->manager)->get('/manager/categories');
        $response->assertStatus(200);
    }
    public function test_create_new_category_without_files_successful()
    {
        $this->withoutExceptionHandling();
        $category = [
            'title_ar'           => 'تيست 4',
            'title_en'           => 'Test 4',
            'category_type_id'   => 1
        ];
        $response =  $this->actingAs($this->manager)->post('manager/categories', $category);
        $response->assertStatus(302);
        $last = Category::query()
            ->withTranslation()->latest()->first();
        $this->assertEquals($category['title_en'], $last->title);
    }
}
