<?php

namespace App\Services\API\User\Nutrition\SuggestedMealPlan;

use App\Models\Recipe;

class AppendFoodExchangeCalculationsToPlanResponseService
{
    public function execute($planResponse)
    {
        $recipesIds =[];
        foreach ($planResponse['meal_types'] as $mealType){
            foreach ($mealType['recipes'] as $recipe){
                $recipesIds [] = $recipe['id'];
            }
        }
        $recipes = Recipe::query()
              ->whereIn('id', $recipesIds)
              ->with('foodExchanges.measurementUnits')
              ->get();

        $servingPerFoodType = $this->countFoodType($recipes);
        $calculations = app(CalculateFoodExchangesMeasurementsForMasterServingService::class)->execute(auth()->guard('user-api')->user(),$recipes,$servingPerFoodType);
        foreach ($planResponse['meal_types'] as $mealTypeIdx => $mealType){
            foreach ($mealType['recipes'] as $recipeIdx => $recipe){
              foreach ($recipe['food_exchanges']as $foodExchangeIdx =>  $foodExchange){
                foreach ($foodExchange['measurement_units']as $measurementUnitIdx => $measurementUnit){
                    $x = $this->findPlanQuantity($calculations,$recipe['id'],$foodExchange['id'],$measurementUnit['id']);
                    $planResponse['meal_types'][$mealTypeIdx]['recipes'][$recipeIdx]['food_exchanges'][$foodExchangeIdx]['measurement_units'][$measurementUnitIdx]['plan_quantity'] = $x;
                }
              }
            }
        }
        return $planResponse;
    }
    public function countFoodType( $recipes): array
    {
        $starches = 0;
        $fruits = 0;
        $vegetables = 0;
        $meats = 0;
        $dairy = 0;
        $oils = 0;
     foreach ($recipes as $recipe){
         foreach ($recipe->foodExchanges as $foodExchange) {
             if ($foodExchange->food_type_id == 1) {
                 $starches += 1;
             } elseif ($foodExchange->food_type_id == 2) {
                 $fruits += 1;
             } elseif ($foodExchange->food_type_id == 3) {
                 $vegetables += 1;
             } elseif ($foodExchange->food_type_id == 4) {
                 $meats += 1;
             } elseif ($foodExchange->food_type_id == 5) {
                 $dairy += 1;
             } else {
                 $oils +=1;
             }
         }
     }
        return [
            'Starches' => $starches,
            'Fruits' => $fruits,
            'Vegetables' =>$vegetables ,
            'Meats' =>$meats ,
            'Dairy' => $dairy,
            'Oils' => $oils,
        ];
    }

    protected function findPlanQuantity($calculations,$recipeId,$foodExchangeId,$measurementUnitId)
    {
        foreach ($calculations as $recipesData){
            foreach ($recipesData['foodExchanges'] as $foodExchangeData){
                foreach ($foodExchangeData['measurementUnits']as $measurementUnit){
                   if ($recipesData['recipe_id'] == $recipeId &&
                       $foodExchangeData['id'] == $foodExchangeId &&
                       $measurementUnit['id'] == $measurementUnitId
                   ){
                       return $measurementUnit['plan_quantity'];
                   }
                }
            }
        }
        return 0;
    }

}
