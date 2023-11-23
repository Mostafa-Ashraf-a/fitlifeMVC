<?php


namespace App\Services\Dashboard\Nutrition;

use App\Models\FoodExchange;
use App\Models\FoodExchangeMeasurement;
use App\Traits\Photoable;
use Illuminate\Support\Facades\Storage;

class FoodExchangeService
{
    use Photoable;
    /**
     * @param $request
     */
    public function store($request) : void
    {
        $model = $this->storeFoodExchange($request);
        if ($request->hasFile('image'))
        {
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$model->id, 'foodExchanges/images/');
            $model->update([
                'image' => $fileName
            ]);
        }
    }

    /**
     * @param $request
     * @return mixed
     */
    private function storeFoodExchange($request) : mixed
    {
        $model = FoodExchange::create([
            'en' => ['title'   => $request->title_en],
            'ar' => ['title'   => $request->title_ar],
            'food_type_id'     => $request->food_type_id,
        ]);
        $this->storeMeasurementUnit($request, $model);
        return $model;
    }

    /**
     * @param $request
     * @param $model
     */
    private function storeMeasurementUnit($request, $model) : void
    {
        if(isset($request->measurement_unit_id))
        {
            foreach ($request->measurement_unit_id as $key => $value)
            {
                FoodExchangeMeasurement::updateOrCreate(
                    [
                        'food_exchange_id' => $model->id,
                        'measurement_unit_id' => $value,
                    ],
                    [
                    'food_exchange_id' => $model->id,
                    'measurement_unit_id' => $value,
                    'quantity' => $request->quantity[$key],
                    ]
                );
            }
        }
    }

    /**
     * @param $request
     * @param $foodExchange
     */
    public function update($request, $foodExchange) : void
    {
        $this->updateFoodExchange($foodExchange, $request);

        if($request->hasFile('image') &&
            ($foodExchange->image != null && Storage::disk('public')->exists('files/foodExchanges/images/'.$foodExchange->id)))
        {
            $this->deleteFile($foodExchange->image,$foodExchange->id, 'foodExchanges/images/');
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$foodExchange->id, 'foodExchanges/images/');
            $foodExchange->update([
                'image' => $fileName
            ]);
        }
        if($request->hasFile('image') &&
            ($foodExchange->image == null))
        {
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$foodExchange->id, 'foodExchanges/images/');
            $foodExchange->update([
                'image' => $fileName
            ]);
        }
    }

    private function updateFoodExchange($foodExchange, $request)
    {
        $foodExchange->update([
            'en' => ['title'   => $request->title_en],
            'ar' => ['title'   => $request->title_ar],
            'food_type_id'     => $request->food_type_id,
        ]);
        $this->storeMeasurementUnit($request, $foodExchange);
    }
}
