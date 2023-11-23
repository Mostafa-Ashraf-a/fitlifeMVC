<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FoodType;
use App\Traits\ApiResponse;
use App\Http\Resources\FoodTypeResource;
class FoodTypeController extends Controller
{
    use ApiResponse;
    public function __construct()
    {
        \request()->headers->set('Accept','application/json');
    }
    public function index()
    {
        $perPage = \request()->query('per_page') ?? 5;
        $foodTypes = FoodType::withTranslation(app()->getLocale());
        $result = FoodTypeResource::setMode('foodTypes')::collection(
            $foodTypes->latest()
                ->paginate($perPage)
                ->appends(['per_page' => $perPage])
        );
        return $this->responseWithPagination($result,$result->all(),$result->currentPage());
    }
}
