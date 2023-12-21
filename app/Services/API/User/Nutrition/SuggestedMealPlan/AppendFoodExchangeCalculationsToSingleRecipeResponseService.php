<?php

namespace App\Services\API\User\Nutrition\SuggestedMealPlan;

use App\Http\Resources\User\Nutrition\Suggested\Running\Daily\PlanResource as DailyRunningResource;
use App\Models\MealPlan;

class AppendFoodExchangeCalculationsToSingleRecipeResponseService
{
    public function execute($recipeResponse, $planId, $duration, $dayNumber)
    {
        $plan         = MealPlan::find($planId);
        $planResponse = app(AppendFoodExchangeCalculationsToPlanResponseService::class)
            ->execute(json_decode(DailyRunningResource::make($plan)->toJson(), true));
        foreach ( $planResponse[ 'meal_types' ] as $mealType ) {
            foreach ( $mealType[ 'recipes' ] as $recipe ) {
                if ( $recipeResponse[ 'id' ] == $recipe[ 'id' ] ) {
                    $recipeResponse = $this->mapResponse($recipeResponse, $recipe);
                    break;
                }
            }
        }
        return $recipeResponse;

    }

    private function mapResponse($recipeResponse, $recipe)
    {
        foreach ( $recipeResponse[ 'ingredients' ] as $ingredientIdx => $ingredient ) {
            foreach ( $recipe[ 'food_exchanges' ] as $foodExchange ) {
                if ( $ingredient[ 'id' ] == $foodExchange[ 'id' ] ) {
                    foreach ( $ingredient[ 'measurement_units' ] as $ingredientMeasurementUnitIdx => $ingredientMeasurementUnit ) {
                        $recipeResponse[ 'ingredients' ][ $ingredientIdx ][ 'measurement_units' ][ $ingredientMeasurementUnitIdx ][ 'quantity' ] =
                            $this->getMeasurement($ingredientMeasurementUnit, $foodExchange);
                    }
                }
            }
        }
        return $recipeResponse;
    }

    private function getMeasurement($ingredientMeasurementUnit, $foodExchange)
    {
        foreach ( $foodExchange[ 'measurement_units' ] as $measurementUnit ) {
            if ( $measurementUnit[ 'id' ] == $ingredientMeasurementUnit[ 'id' ] ) {
                return $measurementUnit[ 'quantity' ];
            }
        }
    }

}