<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Traits\V2\ApiResponseStructure;


class PostController extends Controller
{
    use ApiResponseStructure;

    public function __construct()
    {
        \request()->headers->set('Accept','application/json');
    }

    public function index()
    {
        $perPage = \request()->query('per_page') ?? 10;
        $posts = Post::query()
            ->where('status',1);

        if(\request()->query('category_id'))
        {
            $posts->where('category_id','=',\request()->query('category_id'));
        }
        if(\request()->query('category_type_id'))
        {
            $posts->where('category_type_id','=',\request()->query('category_type_id'));
        }
        return $this->sendResponse(PostResource::collection($posts->latest()->paginate($perPage))->response()->getData(true), ' ', true,200);
    }
}
