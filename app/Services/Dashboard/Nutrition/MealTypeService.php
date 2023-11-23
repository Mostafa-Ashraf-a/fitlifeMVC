<?php


namespace App\Services\Dashboard\Nutrition;


use App\Models\MealType;
use App\Traits\Photoable;
use Illuminate\Support\Facades\Storage;

class MealTypeService
{
    use Photoable;
    /**
     * @param $request
     */
    public function store($request) : void
    {
        $model = $this->storeModel($request);
        if ($request->hasFile('image'))
        {
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$model->id, 'mealTypes/images/');
            $model->update([
                'image' => $fileName
            ]);
        }
    }

    /**
     * @param $request
     * @return mixed
     */
    private function storeModel($request) : mixed
    {
        return MealType::create([
            'en' => ['title' => $request->title_en],
            'ar' => ['title' => $request->title_ar],
        ]);
    }

    public function update($request, $mealType) : void
    {
        $this->updateMealType($mealType, $request);

        if($request->hasFile('image') &&
            ($mealType->image != null && Storage::disk('public')->exists('files/mealTypes/images/'.$mealType->id)))
        {
            $this->deleteFile($mealType->image,$mealType->id, 'mealTypes/images/');
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$mealType->id, 'mealTypes/images/');
            $mealType->update([
                'image' => $fileName
            ]);
        }
        if($request->hasFile('image') &&
            ($mealType->image == null))
        {
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$mealType->id, 'mealTypes/images/');
            $mealType->update([
                'image' => $fileName
            ]);
        }
    }

    private function updateMealType($mealType, $request)
    {
        $mealType->update([
            'en' => ['title' => $request->title_en],
            'ar' => ['title' => $request->title_ar],
        ]);
    }
}
