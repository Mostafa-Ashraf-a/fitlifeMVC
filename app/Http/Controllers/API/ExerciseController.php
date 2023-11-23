<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Http\Resources\ExerciseResource;
use App\Traits\V2\ApiResponseStructure;

class ExerciseController extends Controller
{
    use ApiResponseStructure;

    public function __construct()
    {
        \request()->headers->set('Accept','application/json');
    }

    public function index()
    {
        $perPage = \request()->query('per_page') ?? 10;

        $exercises = Exercise::query()
            ->with(['muscle','level']);

        if(\request()->query('type'))
        {
            $exercises->where('exercise_category',\request()->query('type'));
        }
        if(\request()->query('body_part'))
        {
            $exercises->whereIn('muscle_id',\request()->query('body_part'));
        }
        if(\request()->query('place'))
        {
            $exercises->where('place',\request()->query('place'));
        }
        if(\request()->query('equipment'))
        {
            $exercises->where('equipment_id',\request()->query('equipment'));
        }

        return $this->sendResponse(ExerciseResource::collection($exercises->latest()->paginate($perPage))->response()->getData(true), ' ', true,200);
    }

    public function show($id)
    {
        $exercise = Exercise::query()
            ->with(['muscle','level'])
            ->findOrFail($id);
        return $this->sendResponse(ExerciseResource::make($exercise), ' ', true,200);
    }
}
