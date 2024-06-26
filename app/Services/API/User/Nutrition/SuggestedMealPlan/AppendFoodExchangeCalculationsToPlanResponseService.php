<?php

namespace App\Services\API\User\Nutrition\SuggestedMealPlan;

use App\Models\Recipe;

class AppendFoodExchangeCalculationsToPlanResponseService
{
    protected function getRecipesIds($planResponse){
        $recipesIds =[];
        foreach ($planResponse['meal_types'] as $mealType){
            foreach ($mealType['recipes'] as $recipe){
                $recipesIds [] = $recipe['id'];
            }
        }
        return $recipesIds;
    }
    public function execute($planResponse,$appendCalculationsToResult=false)
    {
        $recipesIds =$this->getRecipesIds($planResponse);
        $recipes = $this->getRecipes($recipesIds);
        $servingPerFoodType = $this->mapServingPerFoodType($planResponse['serving_per_food_types']);
        $calculations = app(CalculateFoodExchangesMeasurementsForMasterServingService2::class)
            ->execute(auth()->guard('user-api')->user(),$recipes,$servingPerFoodType);
        foreach ($planResponse['meal_types'] as $mealTypeIdx => $mealType){

            $planResponse['meal_types'][$mealTypeIdx] = $this->appendMacronutrient($mealType,$calculations);

            foreach ($mealType['recipes'] as $recipeIdx => $recipe){
              foreach ($recipe['food_exchanges']as $foodExchangeIdx =>  $foodExchange){
                foreach ($foodExchange['measurement_units']as $measurementUnitIdx => $measurementUnit){


                    $planResponse['meal_types'][$mealTypeIdx]['recipes'][$recipeIdx]['food_exchanges'][$foodExchangeIdx]['measurement_units'][$measurementUnitIdx]['original_quantity'] =
                        $planResponse['meal_types'][$mealTypeIdx]['recipes'][$recipeIdx]['food_exchanges'][$foodExchangeIdx]['measurement_units'][$measurementUnitIdx]['quantity'];

                    $quantity = $this->findPlanQuantity($calculations,$recipe['id'],$foodExchange['id'],$measurementUnit['id']);
                    $planResponse['meal_types'][$mealTypeIdx]['recipes'][$recipeIdx]['food_exchanges'][$foodExchangeIdx]['measurement_units'][$measurementUnitIdx]['quantity'] = $quantity;

                    $needsCount = $this->findNeedsCount($calculations,$recipe['id'],$foodExchange['id'],$measurementUnit['id']);
                    $planResponse['meal_types'][$mealTypeIdx]['recipes'][$recipeIdx]['food_exchanges'][$foodExchangeIdx]['measurement_units'][$measurementUnitIdx]['needs_count'] = $needsCount;

//                    dd( $this->findServingPercentage($calculations,$recipe['id'],$foodExchange['id'],$measurementUnit['id']));
//                    dd($planResponse['meal_types'][$mealTypeIdx]['recipes'][$recipeIdx]['food_exchanges'][$foodExchangeIdx]['measurement_units'][$measurementUnitIdx]);
//                    $planResponse['meal_types'][$mealTypeIdx]['recipes'][$recipeIdx]['food_exchanges'][$foodExchangeIdx]['measurement_units'][$measurementUnitIdx]['name'] .=
//                      '{('.
//                    $this->findServingPercentage($calculations,$recipe['id'],$foodExchange['id'],$measurementUnit['id']) .')}';



                }
              }
            }
        }
        if ($appendCalculationsToResult){
            return  compact('planResponse','calculations');
        }
        return $planResponse;
    }

    public function mapServingPerFoodType( $ServingPerFoodTypes): array
    {

        $starches = 0;
        $fruits = 0;
        $vegetables = 0;
        $meats = 0;
        $dairy = 0;
        $oils = 0;
     foreach ($ServingPerFoodTypes as $servingPerFoodType){
         switch ($servingPerFoodType['id']){
             case 1:
                 $starches = $servingPerFoodType['serving_value'];
                 break;
             case 2:
                 $fruits = $servingPerFoodType['serving_value'];
                 break;
             case 3:
                 $vegetables = $servingPerFoodType['serving_value'];
                 break;
             case 4:
                 $meats = $servingPerFoodType['serving_value'];
                 break;
             case 5:
                 $dairy = $servingPerFoodType['serving_value'];
                 break;
             case 6:
                 $oils = $servingPerFoodType['serving_value'];
                 break;
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
                       return $measurementUnit['plan_quantity'] ?: 1;
                   }
                }
            }
        }
        return 0;
    }
    protected function findNeedsCount($calculations,$recipeId,$foodExchangeId,$measurementUnitId)
    {
        foreach ($calculations as $recipesData){
            foreach ($recipesData['foodExchanges'] as $foodExchangeData){
                foreach ($foodExchangeData['measurementUnits']as $measurementUnit){
                    if ($recipesData['recipe_id'] == $recipeId &&
                        $foodExchangeData['id'] == $foodExchangeId &&
                        $measurementUnit['id'] == $measurementUnitId
                    ){
                        return $measurementUnit['needs_count'] ?: 0;
                    }
                }
            }
        }
        return 0;
    }

    /**
     * @param array $recipesIds
     * @return Recipe[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\LaravelIdea\Helper\App\Models\_IH_Recipe_C|\LaravelIdea\Helper\App\Models\_IH_Recipe_QB[]
     */
    public function getRecipes(array $recipesIds)
    {
        return Recipe::query()
                     ->whereIn('id', $recipesIds)
                     ->with('foodExchanges.measurementUnits')
                     ->get();
    }

    protected function findServingPercentage($calculations,$recipeId,$foodExchangeId,$measurementUnitId)
    {
        foreach ($calculations as $recipesData){
            foreach ($recipesData['foodExchanges'] as $foodExchangeData){
                foreach ($foodExchangeData['measurementUnits']as $measurementUnit){
                    if ($recipesData['recipe_id'] == $recipeId &&
                        $foodExchangeData['id'] == $foodExchangeId &&
                        $measurementUnit['id'] == $measurementUnitId
                    ){
                        return $measurementUnit['needs_count'] ?: 1;
                    }
                }
            }
        }
        return 0;
    }

    protected function appendMacronutrient($mealType, $calculations)
    {
        $macronutrients = [
            'cal',
            'proteins',
            'carbs',
            'fats'
        ];
       foreach ($macronutrients as $nutrient){
           $mealType[$nutrient] = 0;
       }
       foreach ($mealType['recipes'] as $recipe){
           foreach ($this->getMacronutrientsValue($recipe, $calculations) as $name => $value){
               $mealType[$name] += $value;
           }
       }
        return $mealType;
    }

    private function getMacronutrientsValue($recipe, $calculations)
    {
        foreach ($calculations as $calculation){
            if ($calculation['recipe_id'] == $recipe['id']){
                return $calculation['nutrients'];
            }
        }
        return [];
    }

}
