<?php

namespace Database\Seeders;

use App\Models\FoodExchangeMeasurement;
use Illuminate\Database\Seeder;

class FoodExchangeMeasurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $foodExchanges = FoodExchange::get();
        // $measurements = MeasurementUnit::get();

        $foodExchangeMeasurements = config('food-exchange-measurement.food-exchange-measurement');

        foreach ($foodExchangeMeasurements as $id => $measurement) {
            FoodExchangeMeasurement::create([
                'id'                      => $id,
                'food_exchange_id'        => $measurement['food_exchange_id'],
                'measurement_unit_id'     => $measurement['measurement_unit_id'],
                'quantity'                => $measurement['quantity'],
            ],);
        }
    }
}
