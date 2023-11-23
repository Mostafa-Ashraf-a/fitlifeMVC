<?php


namespace App\Services\Dashboard;


use App\Models\FoodType;
use App\Traits\Photoable;
use Illuminate\Support\Facades\Storage;

class FoodTypeService
{
    use Photoable;

    /**
     * @param $request
     */
    public function store($request) : void
    {
        $foodType = $this->storeFoodType($request);
        if ($request->hasFile('image'))
        {
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$foodType->id, 'foodTypes/images/');
            $foodType->update([
                'image' => $fileName
            ]);
        }
    }

    /**
     * @param $request
     * @return mixed
     */
    private function storeFoodType($request) : mixed
    {
        return FoodType::create([
            'en' => [
                'title' => $request->title_en,
            ],
            'ar' => [
                'title' => $request->title_ar,
            ],
        ]);
    }

    /**
     * @param $request
     * @param $foodType
     */
    public function update($request, $foodType) : void
    {
        $this->updateFoodType($foodType, $request);

        if($request->hasFile('image') &&
            ($foodType->image != null && Storage::disk('public')->exists('files/foodTypes/images/'.$foodType->id)))
        {
            $this->deleteFile($foodType->image,$foodType->id, 'foodTypes/images/');
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$foodType->id, 'foodTypes/images/');
            $foodType->update([
                'image' => $fileName
            ]);
        }
        if($request->hasFile('image') &&
            ($foodType->image == null))
        {
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$foodType->id, 'foodTypes/images/');
            $foodType->update([
                'image' => $fileName
            ]);
        }
    }
    /**
     * @param $foodType
     * @param $request
     */
    public function updateFoodType($foodType, $request): void
    {
        $foodType->update([
            'en' => [
                'title' => $request->title_en,
            ],
            'ar' => [
                'title' => $request->title_ar,
            ],
        ]);
    }
}
