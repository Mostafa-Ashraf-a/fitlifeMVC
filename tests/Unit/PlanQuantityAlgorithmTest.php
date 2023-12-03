<?php

namespace Tests\Unit;

use App\Models\Recipe;
use App\Models\User;
use App\Services\API\User\Nutrition\SuggestedMealPlan\CalculateFoodExchangesMeasurementsForMasterServingService;
use PHPUnit\Framework\TestCase;

class PlanQuantityAlgorithmTest extends TestCase
{
    const Starches_ID   = 1;
    const Fruits_ID     = 2;
    const Vegetables_ID = 3;
    const Meats_ID      = 4;
    const Dairy_ID      = 5;
    const Oils_ID       = 6;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_calculate_correct_example_1()
    {
        $user = User::first();
        $recipes = Recipe::whereIn('id',[7,4,6])->with('foodExchanges.measurementUnits')->get();
        $servingPerFoodType = [
            "Starches"   => 5.0,
            "Fruits"     => 1.0,
            "Vegetables" => 4.0,
            "Meats"      => 2.0,
            "Dairy"      => 2.0,
            "Oils"       => 0,
        ];
        $mappedServingPerFoodType = collect($servingPerFoodType)->mapWithKeys(function ($value, $type) {
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
       $mappedRecipes =  (new CalculateFoodExchangesMeasurementsForMasterServingService())->execute($user,$recipes,$servingPerFoodType);
       $this->assertTrue(count($mappedServingPerFoodType) == count($mappedRecipes['compare'] ));
        foreach ($mappedRecipes['compare'] as $foodTypeId => $quantity){
            $this->assertTrue($mappedServingPerFoodType[$foodTypeId] == $quantity);
        }

    }
}
