<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Traits\V2\ApiResponseStructure;

class CategoryController extends Controller
{
    use ApiResponseStructure;
    public function __construct()
    {
        \request()->headers->set('Accept','application/json');
    }

    public function show($id)
    {
        $perPage = \request()->query('per_page') ?? 10;
        $posts = Category::query()->where('category_type_id',$id)->latest();
        return $this->sendResponse(CategoryResource::collection($posts->paginate($perPage))->response()->getData(true), ' ', true,200);
    }
}
