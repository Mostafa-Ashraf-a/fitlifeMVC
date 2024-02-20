<?php

namespace App\Services\API\User\Nutrition\SuggestedMealPlan;

use App\Models\FoodExchange;
use App\Models\MealPlan;
use App\Models\MealType;
use App\Models\Recipe;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CalculateFoodExchangesMeasurementsForMasterServingService2
{
    const WEEKLY_PLAN        = 2;
    const ACTIVE_WEEKLY_PLAN = 1;

    const Starches_ID   = 1;
    const Fruits_ID     = 2;
    const Vegetables_ID = 3;
    const Meats_ID      = 4;
    const Dairy_ID      = 5;
    const Oils_ID       = 6;

    public function execute(User $user,$recipes,$servingPerFoodType)
    {
        $servingPerFoodType = $this->mapServingPerFoodType($servingPerFoodType);
        $recipes = $this->mapRecipes($recipes);
        $recipesServingPerFoodTypes = $this->getRecipesFoodTypes($recipes);
        $percentage = $this->getFoodExchangePercentage($servingPerFoodType,$recipesServingPerFoodTypes);

        $res =[];
        foreach ($recipes as $recipe){
            $recipesData = [
                'recipe_id' => $recipe['recipe_id'],
                'foodExchanges' => []
            ];
            foreach ($recipe['foodExchanges'] as $foodExchange){
                $foodExchangeData = [
                    'id'  => $foodExchange['food_exchange_id'],
                    'food_type_id' => $foodExchange['food_type_id'],
                    'measurementUnits' => []
                ];
                foreach ($foodExchange['measurementUnits']as $measurementUnit){
//                    dd($measurementUnit);
                    $measurementUnitData = [
                        'id' => $measurementUnit['measurement_unit_id'],
                        'plan_quantity' =>(($measurementUnit['quantity'] ??0) * $percentage[$foodExchange['food_type_id']]) ,
                        'quantity' =>$measurementUnit['quantity'] ??0,
                        'needs_count' =>  $percentage[$foodExchange['food_type_id']]
                    ];
                    $foodExchangeData['measurementUnits'][] = $measurementUnitData;
                }
                $recipesData['foodExchanges'][]=$foodExchangeData;
            }
            $res[] = $recipesData;
        }

        return $this->appendNutrient($res);
    }


    protected function appendNutrient($recipes)
    {
       foreach ($recipes as $idx => $recipe){
//        dd($recipe);
           $recipes[$idx]['nutrients']=[
               'cal' =>0,
               'proteins' =>0,
               'carbs' =>0,
               'fats' =>0,
           ];
//           $needs =[
//               1=>0,
//               2=>0,
//               3=>0,
//               4=>0,
//               5=>0,
//           ];
           foreach ($recipe['foodExchanges'] as $foodExchange){
//               $needs[$foodExchange['food_type_id']] +=$foodExchange['measurementUnits'][0]['needs_count'] ??0;
               foreach ($this->getNutrientsValue($foodExchange) as $name => $value){
                $recipes[$idx]['nutrients'][$name] +=$value  ;
               }
           }
//           dd($needs);

       }
//       dd($recipes);
       return $recipes;

    }

    protected function getNutrientsValue($foodExchange)
    {
        return app(GetNutrientsValueService::class)->execute($foodExchange);

//        $needsCount = $foodExchange['measurementUnits'][0]['needs_count'] ??0;
//        switch ($foodExchange['food_type_id']){
//            case self::Starches_ID :
//                return [
//                        'cal' =>80 * $needsCount,
//                    'proteins' =>3 * $needsCount,
//                    'carbs' =>15 * $needsCount,
//                    'fats' =>0 * $needsCount,
//                ];
//            case self::Dairy_ID :
//                return [
//                    'cal' =>120 * $needsCount,
//                    'proteins' =>8 * $needsCount,
//                    'carbs' =>12 * $needsCount,
//                    'fats' =>5 * $needsCount,
//                ];
//            case self::Fruits_ID :
//                return [
//                    'cal' =>60 * $needsCount,
//                    'proteins' =>0 * $needsCount,
//                    'carbs' =>15 * $needsCount,
//                    'fats' =>0 * $needsCount,
//                ];
//            case self::Vegetables_ID :
//                return [
//                    'cal' =>25 * $needsCount,
//                    'proteins' =>2 * $needsCount,
//                    'carbs' =>5 * $needsCount,
//                    'fats' =>0 * $needsCount,
//                ];
//            case self::Meats_ID :
//                return [
//                    'cal' =>75 * $needsCount,
//                    'proteins' =>7 * $needsCount,
//                    'carbs' =>0 * $needsCount,
//                    'fats' =>5 * $needsCount,
//                ];
//            case self::Oils_ID :
//                return [
//                    'cal' =>45 * $needsCount,
//                    'proteins' =>0 * $needsCount,
//                    'carbs' =>0 * $needsCount,
//                    'fats' =>5 * $needsCount,
//                ];
//            default:
//                return  [
//                    'cal' =>0,
//                    'proteins' =>0,
//                    'carbs' =>0,
//                    'fats' =>0,
//                ];
//        }
    }

    private function mapServingPerFoodType($servingPerFoodType)
    {
//        $servingPerFoodType = $this->getStaticFoodExchangePerFoodType();
        return collect($servingPerFoodType)->mapWithKeys(function ($value, $type) {
            $typeId = null;
            switch ($type) {
                case 'Starches':
                    $typeId = self::Starches_ID;
                    break;
                case 'Fruits':
                    $typeId = self::Fruits_ID;
                    break;
                case 'Vegetables':
                    $typeId = self::Vegetables_ID;
                    break;
                case 'Meats':
                    $typeId = self::Meats_ID;
                    break;
                case 'Dairy':
                    $typeId = self::Dairy_ID;
                    break;
                case 'Oils':
                    $typeId = self::Oils_ID;
                    break;
            }
            return [
                $typeId => $value
            ];
        });
    }

    private function getRecipesFoodTypes($recipes)
    {
        $foodTypes = [];
        foreach ($recipes as $recipe){
            foreach ($recipe['foodExchanges'] as $foodExchange){
                if(!isset($foodTypes[$foodExchange['food_type_id']])){
                    $foodTypes[$foodExchange['food_type_id']] = 0;
                }
                $foodTypes[$foodExchange['food_type_id']] +=1;
            }
        }
//        $foodTypes[2] = 3;
        return $foodTypes;

    }

    private function getFoodExchangePercentage($suggestedServingPerFoodTypes,$recipesServingPerFoodTypes)
    {
        $percentage =[];
        foreach ($suggestedServingPerFoodTypes as $foodType => $needs){
            if ($foodType == self::Fruits_ID){
//                dd($foodType,$needs,$recipesServingPerFoodTypes[$foodType]);
            }
            $percentage[$foodType] = ceil($needs/($recipesServingPerFoodTypes[$foodType] ?? 1)) ?? 1;
        }
       return $percentage;

    }

    /**
     * @param $recipes
     * @return \Illuminate\Support\Collection
     */
    private function mapRecipes($recipes): \Illuminate\Support\Collection
    {
        return collect($recipes)->map(function (Recipe $recipe) {
            return [
                'recipe_id'     => $recipe->id,
                'foodExchanges' => $recipe->foodExchanges->map(function (FoodExchange $foodExchange) {
                    return [
                        'food_exchange_id' => $foodExchange->id,
                        'food_type_id'     => $foodExchange->food_type_id,
                        'measurementUnits' => $foodExchange->measurementUnits->map(function ($unit) {
                            return [
                                'measurement_unit_id' => $unit->id,
                                'quantity'            => $unit->pivot->quantity
                            ];
                        })
                    ];
                })
            ];
        });
    }

    /**
     * @return int[]
     */
    public function getStaticFoodExchangePerFoodType(): array
    {
        return [
            "Starches"   => 4,
            "Fruits"     => 1,
            "Vegetables" => 2,
            "Meats"      => 4,
            "Dairy"      => 2,
            "Oils"       => 2,
        ];
    }
}
