<?php

namespace App\Http\Controllers\API\User\Exercise\Program;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ExercisePrgramSuggestionRequest;
use App\Http\Resources\User\Exercise\Program\SuggestionResource;
use App\Http\Resources\User\Exercise\Program\Weekly\WeeklyResource;
use App\Models\User;
use App\Services\API\User\Exercise\Program\SuggestionService;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;

class SuggestionController extends Controller
{
    use ApiResponse;
    private $service;

    public function __construct(SuggestionService $service)
    {
        \request()->headers->set('Accept','application/json');
        $this->service = $service;
    }

    public function index()
    {
        if(\request()->query('duration') == 1)
        {

            $this->service->insertIntoDailyRunningProgram();
            $plan = User::with('program.exerciseType.muscles.exerciseSuggestions')
                ->where('id',auth()->guard('user-api')->user()->id)
                ->first();
            
            return $this->success(" ",SuggestionResource::make($plan));
        }
        if(\request()->query('duration') == 2)
        {
            $this->service->insertIntoWeeklyRunningProgram();
            $plans = DB::table('user_exercise_program_suggestions')
                ->where('user_id',auth()->guard('user-api')->user()->id)
                ->where('program_duration', 2)
                ->groupBy('day_id')
                ->orderBy('day_id', 'ASC')
                ->select('day_id as day_number','start_at','end_at')
                ->get();
            return $this->success(" ",$plans);
        }
        return $this->error(" ",400);
    }

    public function store(ExercisePrgramSuggestionRequest $request)
    {
        $user = auth()->guard('user-api')->user();
        $program = $this->service->store($request, $user);
        if($program)
        {
            return $this->success(" ", true);
        }else{
            return $this->success(__('api.There are no programs available with your selections, please try again'), null);
        }
    }

    public function show($dayId)
    {
        $plan = User::whereHas('weeklyProgram', function ($query) use($dayId){
            $query->where('day_id', $dayId);
        })
            ->first();
dd($plan);
     
   return $this->success(" ",WeeklyResource::make($plan));
    }
}
