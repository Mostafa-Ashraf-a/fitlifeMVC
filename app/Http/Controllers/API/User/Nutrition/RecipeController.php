<?php

namespace App\Http\Controllers\API\User\Nutrition;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\Nutrition\RecipeResource;
use App\Models\MealRecipe;
use App\Models\MealType;
use App\Models\Recipe;
use App\Services\API\User\Nutrition\SuggestedMealPlan\AppendFoodExchangeCalculationsToSingleRecipeResponseService;
use App\Traits\ApiResponse;

class RecipeController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        \request()->headers->set('Accept','application/json');
    }

    public function show(Recipe $recipe)
    {
        if(\request()->query('shuffle') == 1 && \request()->query('meal_type_id'))
        {
            MealType::findOrFail(\request()->query('meal_type_id'));
            $recipes = MealRecipe::query()
                ->where('meal_type_id',\request()->query('meal_type_id'))
                ->get()
                ->pluck('recipe_id')
                ->toArray();
            if($recipes)
            {
                $shuffle = Recipe::query()
                    ->where('id','!=',$recipe->id)
                    ->whereIn('id',$recipes)
                    ->inRandomOrder()
                    ->limit(1)
                    ->first();
                if($shuffle)
                {
                    return $this->success(" ", RecipeResource::make($shuffle));
                }
                return $this->success(" ", null);
            }
        }
        return $this->success(
            " ",
            (new AppendFoodExchangeCalculationsToSingleRecipeResponseService())
                ->execute(
                    json_decode(RecipeResource::make($recipe)->toJson(), true),
                    request('plan_id'),
                    request('duration'),
                    request('day_number'),
                )
        );
    }

    public function shuffle($mealTypeId)
    {
        $mealType = MealType::findOrFail($mealTypeId);
        $exceptRecipes = explode(',',\request()->query('recipes'));
        $recipes = MealRecipe::query()
            ->where('meal_type_id',$mealType->id)
            ->get()
            ->pluck('recipe_id')
            ->toArray();

        if($recipes)
        {
            $shuffle = Recipe::query()
                ->whereIn('id',$recipes)
                ->whereNotIn('id', $exceptRecipes)
                ->inRandomOrder()
                ->get();
            return $this->success(" ", RecipeResource::collection($shuffle));
        }
    }
}
