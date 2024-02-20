<?php

namespace App\Services\API\User\Nutrition\SuggestedMealPlan;

class GetNutrientsValueService
{
    const Starches_ID   = 1;
    const Fruits_ID     = 2;
    const Vegetables_ID = 3;
    const Meats_ID      = 4;
    const Dairy_ID      = 5;
    const Oils_ID       = 6;

    public function execute($foodExchange)
    {
        $needsCount = $foodExchange['measurementUnits'][0]['needs_count'] ??0;
        switch ($foodExchange['food_type_id']){
            case self::Starches_ID :
                return [
                    'cal' =>80 * $needsCount,
                    'proteins' =>3 * $needsCount,
                    'carbs' =>15 * $needsCount,
                    'fats' =>0 * $needsCount,
                ];
            case self::Dairy_ID :
                return [
                    'cal' =>120 * $needsCount,
                    'proteins' =>8 * $needsCount,
                    'carbs' =>12 * $needsCount,
                    'fats' =>5 * $needsCount,
                ];
            case self::Fruits_ID :
                return [
                    'cal' =>60 * $needsCount,
                    'proteins' =>0 * $needsCount,
                    'carbs' =>15 * $needsCount,
                    'fats' =>0 * $needsCount,
                ];
            case self::Vegetables_ID :
                return [
                    'cal' =>25 * $needsCount,
                    'proteins' =>2 * $needsCount,
                    'carbs' =>5 * $needsCount,
                    'fats' =>0 * $needsCount,
                ];
            case self::Meats_ID :
                return [
                    'cal' =>75 * $needsCount,
                    'proteins' =>7 * $needsCount,
                    'carbs' =>0 * $needsCount,
                    'fats' =>5 * $needsCount,
                ];
            case self::Oils_ID :
                return [
                    'cal' =>45 * $needsCount,
                    'proteins' =>0 * $needsCount,
                    'carbs' =>0 * $needsCount,
                    'fats' =>5 * $needsCount,
                ];
            default:
                return  [
                    'cal' =>0,
                    'proteins' =>0,
                    'carbs' =>0,
                    'fats' =>0,
                ];
        }
    }
}
