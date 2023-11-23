<?php

namespace Tests\Feature\Dashboard\Controllers\Nutrition;

use App\Models\Goal;
use App\Models\Meal;
use App\Models\MealType;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MealPlanTest extends TestCase
{
    use RefreshDatabase;
    private $baseUrl = '/manager/nutrition/';

    public function test_meal_plans_index_page_return_success()
    {
        $this->withoutExceptionHandling();
        $response = $this->actingAs($this->manager)->get($this->baseUrl.'meal-plans');
        $response->assertOk();
    }

    public function test_meal_plans_index_page_return_404_invalid_url()
    {
        $response = $this->actingAs($this->manager)->get($this->baseUrl.'meal-planstest');
        $response->assertNotFound();
    }

    public function test_create_meal_plans_return_success()
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
            [
                'id'    => 2,
                'ar' => [
                    'title'   => "وجبة الغداء"
                ],
                'en' => [
                    'title'   => "Lunch"
                ],
            ],
        ]);
        $goal = Goal::create([
            [
                'id'    => 1,
                'ar' => [
                    'title'   => "خسارة وزن"
                ],
                'en' => [
                    'title'   => "Lose"
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
        $response = $this->followingRedirects()->actingAs($this->manager)->post($this->baseUrl.'meals', $meal);
        $response->assertOk();

        $meals = Meal::get();
        $mealTypes = MealType::get();
        $mealPlanRequestBody = [
            'title'          => "Test Meal Plan Name",
            'goal_id'        => $goal->id,
            'meal_type_id'   =>  array($mealTypes[0]['id']),
            'meal_id'        =>  array($meals[0]['id']),
        ];

        $mealPlanResponse = $this->followingRedirects()->actingAs($this->manager)->post($this->baseUrl.'meal-plans', $mealPlanRequestBody);
        $mealPlanResponse->assertOk();
    }
}
