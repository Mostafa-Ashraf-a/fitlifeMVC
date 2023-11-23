<?php


namespace App\Services\Dashboard;


use App\Models\Category;
use App\Traits\Photoable;
use Illuminate\Support\Facades\Storage;

class CategoryService
{
    use Photoable;

    /**
     * @param $request
     */
    public function store($request) : void
    {
        $category = $this->storeCategory($request);
        if ($request->hasFile('image'))
        {
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$category->id, 'categories/images/');
            $category->update([
                'image' => $fileName
            ]);
        }
    }

    /**
     * @param $request
     * @return mixed
     */
    private function storeCategory($request) : mixed
    {
        return Category::create([
            'en' => [
                'title' => $request->title_en,
            ],
            'ar' => [
                'title' => $request->title_ar,
            ],
            'category_type_id'=>$request->category_type_id,
        ]);
    }

    /**
     * @param $request
     * @param $category
     */
    public function update($request, $category) : void
    {
        $this->updateCategory($category, $request);

        if($request->hasFile('image') &&
            ($category->image != null && Storage::disk('public')->exists('files/categories/images/'.$category->id)))
        {
            $this->deleteFile($category->image,$category->id, 'categories/images/');
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$category->id, 'categories/images/');
            $category->update([
                'image' => $fileName
            ]);
        }
        if($request->hasFile('image') &&
            ($category->image == null))
        {
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$category->id, 'categories/images/');
            $category->update([
                'image' => $fileName
            ]);
        }
    }

    /**
     * @param $category
     * @param $request
     */
    public function updateCategory($category, $request): void
    {
        $category->update([
            'en' => [
                'title' => $request->title_en,
            ],
            'ar' => [
                'title' => $request->title_ar,
            ],
            'category_type_id' => $request->category_type_id,
        ]);
    }

}
