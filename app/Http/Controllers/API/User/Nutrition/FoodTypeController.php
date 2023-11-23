<?php

namespace App\Http\Controllers\API\User\Nutrition;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\Nutrition\FoodTypeResource;
use App\Models\FoodType;
use App\Traits\ApiResponse;

class FoodTypeController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        \request()->headers->set('Accept', 'application/json');
    }

    public function index()
    {
        $perPage = \request()->query('per_page') ?? 10;

        $result = FoodTypeResource::collection(
            FoodType::paginate($perPage)->appends(['per_page' => $perPage])
        );

        return $this->responseWithPagination($result, $result->all(), $result->currentPage());
    }
}
