<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryTypeResource;
use App\Models\CategoryType;
use App\Traits\V2\ApiResponseStructure;

class CategoryTypeController extends Controller
{
    use ApiResponseStructure;
    public function __construct()
    {
        \request()->headers->set('Accept','application/json');
    }

    public function index()
    {
        $perPage = \request()->query('per_page') ?? 10;
        $data = CategoryType::query()->latest();
        return $this->sendResponse(CategoryTypeResource::collection($data->paginate($perPage))->response()->getData(true), ' ', true,200);

    }
}
