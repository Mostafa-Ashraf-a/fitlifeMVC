<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\CategoryType;
use App\Models\Post;
use App\Services\Dashboard\CategoryService;
use App\Traits\General;
use App\Traits\Photoable;

class CategoryController extends Controller
{
    use Photoable;
    public function index()
    {
        $categories = Category::query()->with('type')->orderBy('id','DESC')->get();
        return view('admin.Categories.index',compact('categories'));
    }
    public function create()
    {
        $categoryTypes = CategoryType::get();
        return view('admin.Categories.add',compact('categoryTypes'));
    }
    public function store(AddCategoryRequest $request)
    {
        $service = new CategoryService();
        $service->store($request);
        $notification = array('message' => "Category Added Successfully!",'alert-type' => 'success');
        return redirect()->to('/manager/categories')->with($notification);
    }
    public function edit($id)
    {
        $category = Category::find($id);
        $categoryTypes = CategoryType::get();
        $categoryEn = CategoryTranslation::where('category_id',$id)->where('locale','=','en')->select('title as title_en')->first();
        $categoryAr = CategoryTranslation::where('category_id',$id)->where('locale','=','ar')->select('title as title_ar')->first();
        return view('admin.Categories.edit',compact('category','categoryTypes','categoryAr','categoryEn'));
    }
    public function update(AddCategoryRequest $request, Category $category)
    {
        $service = new CategoryService();
        $service->update($request, $category);
        $notification = array('message' => "Category Updated Successfully!",'alert-type' => 'info');
        return redirect()->to('/manager/categories')->with($notification);
    }
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $post = Post::where('category_id', $id)->first();
        if($post)
        {
            return response()->json(['message' => "You can`t delete the Category, it has a Post"],400);
        }
        if($category->image != null)
        {
            $this->deleteFile($category->image,$category->id, 'categories/images/');
        }
        $category->delete();
        return response()->json(['message' => "Category Has been Deleted Successfully!"],200);
    }
}
