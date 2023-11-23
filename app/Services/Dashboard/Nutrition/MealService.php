<?php


namespace App\Services\Dashboard\Nutrition;


use App\Models\Meal;
use App\Models\MealRecipe;
use App\Traits\Photoable;
use Illuminate\Support\Facades\Storage;

class MealService
{
    use Photoable;
    /**
     * @param $request
     */
    public function store($request) : void
    {
        $this->storeMeal($request);
    }

    /**
     * @param $request
     * @return mixed
     */
    private function storeMeal($request) : mixed
    {
        $model = Meal::create([
            'en' => [
                'title'         => $request->title_en,
            ],
            'ar' => [
                'title'         => $request->title_ar,
            ],
            'meal_type_id'      => $request->meal_type_id
        ]);
        $this->storeRecipes($request, $model);
        return $model;
    }

    /**
     * @param $request
     * @param $model
     */
    private function storeRecipes($request, $model) : void
    {
        $model->recipes()->attach($request->recipe_id,['meal_type_id'=>$request->meal_type_id]);
    }


    public function update($request, $meal) : void
    {
        $this->updateMeal($meal, $request);
    }

    private function updateMeal($meal, $request)
    {
        if($meal->is_default != 1)
        {
            $meal->update([
                'en' => [
                    'title'          => $request->title_en,
                ],
                'ar' => [
                    'title'          => $request->title_ar,
                ],
            ]);
        }else{
            $meal->update([
                'en' => [
                    'title'          => $request->title_en,
                ],
                'ar' => [
                    'title'          => $request->title_ar,
                ],
                'meal_type_id'      => $request->meal_type_id
            ]);
            $meal->recipes()->syncWithPivotValues($request->recipe_id,['meal_type_id'=>$request->meal_type_id]);
        }
    }
}
