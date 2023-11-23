<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExerciseTypesResource;
use App\Models\ExerciseType;
use App\Traits\V2\ApiResponseStructure;

class ExerciseTypeController extends Controller
{
    use ApiResponseStructure;

    public function __construct()
    {
        \request()->headers->set('Accept','application/json');
    }

    public function index()
    {
        $perPage = \request()->query('per_page') ?? 10;
        $exerciseTypes = ExerciseType::query()->latest();
        return $this->sendResponse(ExerciseTypesResource::collection($exerciseTypes->paginate($perPage))->response()->getData(true), ' ', true,200);
    }
}
