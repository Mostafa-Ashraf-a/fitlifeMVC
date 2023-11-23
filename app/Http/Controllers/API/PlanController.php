<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;
use App\Models\PlanManagement;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    use ApiResponse;
    public function __construct()
    {
        \request()->headers->set('Accept','application/json');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $plans = PlanManagement::query()
            ->where('is_active',1)
            ->with('planDuration')
            ->get();
        return $this->success(" ", PlanResource::collection($plans));
    }
}
