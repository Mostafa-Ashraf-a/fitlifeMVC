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
                        'plan_quantity' =>round((($measurementUnit['quantity'] ??0) * $percentage[$foodExchange['food_type_id']]),3) ,
                        'quantity' =>$measurementUnit['quantity'] ??0,
                        'needs_count' => ($measurementUnit['plan_quantity']??0)/$measurementUnit['quantity']
                    ];
                    $foodExchangeData['measurementUnits'][] = $measurementUnitData;
                }
                $recipesData['foodExchanges'][]=$foodExchangeData;
            }
            $res[] = $recipesData;
        }
        return $res;
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
            $percentage[$foodType] = round($needs/($recipesServingPerFoodTypes[$foodType] ?? 1),1);
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
