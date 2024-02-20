<?php

namespace App\Services\API\User\Nutrition\SuggestedMealPlan;

use App\Http\Resources\User\Nutrition\Suggested\Running\Daily\PlanResource as DailyRunningResource;
use App\Models\MealPlan;

class AppendFoodExchangeCalculationsToSingleRecipeResponseService
{
    public function execute($recipeResponse, $planId, $duration, $dayNumber)
    {

        $plan         = MealPlan::find($planId);
        $result = app(AppendFoodExchangeCalculationsToPlanResponseService::class)
            ->execute(json_decode(DailyRunningResource::make($plan)->toJson(), true),true);
        $calculations = $result['calculations'];
        $planResponse = $result['planResponse'];
        foreach ( $planResponse[ 'meal_types' ] as $mealType ) {
            foreach ( $mealType[ 'recipes' ] as $recipe ) {
                if ( $recipeResponse[ 'id' ] == $recipe[ 'id' ] ) {
                    $recipeResponse = $this->mapResponse($recipeResponse, $recipe);
                    $recipeResponse = $this->appendMacronutrient($recipeResponse, $recipe);
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

                        $recipeResponse[ 'ingredients' ][ $ingredientIdx ][ 'measurement_units' ][ $ingredientMeasurementUnitIdx ][ 'name' ] =
                             $this->getNameWithServingPercentage($ingredientMeasurementUnit, $foodExchange);
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
    private function getNameWithServingPercentage($ingredientMeasurementUnit, $foodExchange)
    {
        foreach ( $foodExchange[ 'measurement_units' ] as $measurementUnit ) {
            if ( $measurementUnit[ 'id' ] == $ingredientMeasurementUnit[ 'id' ] ) {
                return $measurementUnit[ 'name' ];
            }
        }
    }

    private function appendMacronutrient(array $recipeResponse, $recipe)
    {
        $res=[
            'cal'=> 0,
            'proteins'=>0,
            'carbs'=>0,
            'fats'=>0
        ];
        foreach ( $recipe[ 'food_exchanges' ] as $foodExchange ) {
            $foodExchange[ 'food_type_id' ] = $foodExchange[ 'food_type' ];
            $foodExchange[ 'measurementUnits' ] = $foodExchange[ 'measurement_units' ];
            foreach ( app(GetNutrientsValueService::class)->execute($foodExchange) as $name => $value ) {
                $res[$name] += $value;
            }
        }
        $recipeResponse['macronutrients'] = $res;
        return $recipeResponse;
    }

}
