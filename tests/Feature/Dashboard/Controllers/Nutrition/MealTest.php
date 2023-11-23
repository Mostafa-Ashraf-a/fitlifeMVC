<?php

namespace Tests\Feature\Dashboard\Controllers\Nutrition;

use App\Models\Meal;
use App\Models\MealType;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MealTest extends TestCase
{
    use RefreshDatabase;
    private $baseUrl = '/manager/nutrition/meals';

    public function test_meals_index_page_return_success()
    {
        $this->withoutExceptionHandling();
        $mealType = MealType::create([
            [
                'id'    => 1,
                'ar' => [
                    'title'   => "وجبة الفطار"
                ],
                'en' => [
                    'title'   => "Break Fast"
                ],
            ],
        ]);
        $meal = Meal::create([
            [
                'id'    => 1,
                'ar' => [
                    'title'   => "وجبة الفطار"
                ],
                'en' => [
                    'title'   => "Break Fast Meal Name"
                ],
            ],
            'meal_type_id'     => $mealType->id
        ]);
        $response = $this->actingAs($this->manager)->get($this->baseUrl);
        $response->assertOk();
        $response->assertSeeText($meal->title);
        $response->assertSeeText('Admin');
    }

    public function test_meals_index_page_return_404()
    {
        $response = $this->actingAs($this->manager)->get('/manager/nutrition/meals1');
        $response->assertNotFound();
    }

    public function test_create_meal_with_meal_type_and_recipe_return_success()
    {
        $this->withoutExceptionHandling();
        $mealType = MealType::create([
            [
                'id'    => 1,
                'ar' => [
                    'title'   => "وجبة الفطار"
                ],
                'en' => [
                    'title'   => "Break Fast"
                ],
            ],
        ]);
        $recipes = [
            [
                'id'    => 1,
                'ar' => [
                    'title'         => "تيست",
                    'instructions'  => 'تعليمات',
                ],
                'en' => [
                    'title'          => "test",
                    'instructions'   => "instructions"
                ],
            ],
            [
                'id'    => 2,
                'ar' => [
                    'title'         => "تيست",
                    'instructions'  => 'تعليمات',
                ],
                'en' => [
                    'title'          => "test",
                    'instructions'   => "instructions"
                ],
            ],
        ];
        foreach($recipes as $recipe){
            Recipe::create($recipe);
        }
        $getRecipes = Recipe::get();

        $meal = [
                'title_ar'         => "وجبة الفطار",
                'title_en'         => "Break Fast Meal Name",
                'meal_type_id'     => $mealType->id,
                'recipe_id'        => array($getRecipes[0]['id'],$getRecipes[1]['id'])
            ];
        $response = $this->followingRedirects()->actingAs($this->manager)->post($this->baseUrl, $meal);
        $response->assertOk();
    }
}
