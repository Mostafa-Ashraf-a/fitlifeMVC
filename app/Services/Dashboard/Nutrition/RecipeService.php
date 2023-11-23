<?php


namespace App\Services\Dashboard\Nutrition;

use App\Models\Recipe;
use App\Models\RecipeFoodExchange;
use App\Traits\Photoable;
use Illuminate\Support\Facades\Storage;

class RecipeService
{
    use Photoable;
    /**
     * @param $request
     */
    public function store($request) : void
    {
        $model = $this->storeRecipe($request);
        if ($request->hasFile('image'))
        {
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$model->id, 'recipes/images/');
            $model->update([
                'image' => $fileName
            ]);
        }
    }

    /**
     * @param $request
     * @return mixed
     */
    private function storeRecipe($request) : mixed
    {
        $model = Recipe::create([
            'en' => [
                'title'         => $request->title_en,
                'instructions'   => $request->instruction_en,
                'other_info'    => $request->other_info_en,
            ],
            'ar' => [
                'title'         => $request->title_ar,
                'instructions'   => $request->instruction_ar,
                'other_info'    => $request->other_info_ar,
            ],
        ]);
        $this->storeFoodExchanges($request, $model);
        return $model;
    }

    /**
     * @param $request
     * @param $model
     */
    private function storeFoodExchanges($request, $model) : void
    {
        if(isset($request->food_exchange_id))
        {
            foreach ($request->food_exchange_id as $key => $value)
            {
                RecipeFoodExchange::updateOrCreate(
                    [
                        'recipe_id'         => $model->id,
                        'food_exchange_id'  => $value,
                    ],
                    [
                        'recipe_id'         => $model->id,
                        'food_exchange_id'  => $value,
                    ]
                );
            }
        }
    }


    public function update($request, $recipe) : void
    {
        $this->updateRecipe($recipe, $request);

        if($request->hasFile('image') &&
            ($recipe->image != null && Storage::disk('public')->exists('files/recipes/images/'.$recipe->id)))
        {
            $this->deleteFile($recipe->image,$recipe->id, 'recipes/images/');
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$recipe->id, 'recipes/images/');
            $recipe->update([
                'image' => $fileName
            ]);
        }
        if($request->hasFile('image') &&
            ($recipe->image == null))
        {
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$recipe->id, 'recipes/images/');
            $recipe->update([
                'image' => $fileName
            ]);
        }
    }

    private function updateRecipe($recipe, $request)
    {
        $recipe->update([
            'en' => [
                'title'          => $request->title_en,
                'instructions'   => $request->instruction_en,
                'other_info'     => $request->other_info_en,
            ],
            'ar' => [
                'title'          => $request->title_ar,
                'instructions'   => $request->instruction_ar,
                'other_info'     => $request->other_info_ar,
            ],
        ]);
        $this->storeFoodExchanges($request, $recipe);
    }
}
