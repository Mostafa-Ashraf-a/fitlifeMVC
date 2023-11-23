<?php

namespace Database\Seeders;

use App\Models\FoodExchange;
use Illuminate\Database\Seeder;

class FoodExchangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $foodExchanges = config('food-exchanges.food-exchanges');

        foreach ($foodExchanges as $id => $food_exchange) {

            FoodExchange::create([
                'id'                  => $id,
                'food_type_id'           => $food_exchange['food_type_id'],
                'ar' => [
                    'title'           => $food_exchange['ar'],
                ],
                'en' => [
                    'title'         => $food_exchange['en'],
                ],
            ],);
        }
    }
}
