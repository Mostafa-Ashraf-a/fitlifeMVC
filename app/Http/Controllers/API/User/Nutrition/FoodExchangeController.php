<?php

namespace App\Http\Controllers\API\User\Nutrition;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\Nutrition\FoodExchangeResource;
use App\Models\FoodExchange;
use App\Traits\ApiResponse;

class FoodExchangeController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        \request()->headers->set('Accept','application/json');
    }

    public function index()
    {
        $perPage = \request()->query('per_page') ?? 5;

        $foodExchange = FoodExchange::query()
            ->with('foodType','measurementUnits');

        if(\request()->query('food_type_id'))
        {
            $foodExchange->where('food_type_id','=',\request()->query('food_type_id'));
        }

        $result = FoodExchangeResource::collection(
            $foodExchange->orderBy('id','DESC')
                ->paginate($perPage)
                ->appends(['per_page' => $perPage])
        );

        return $this->responseWithPagination($result,$result->all(),$result->currentPage());
    }
}
