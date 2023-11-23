<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\questionnaireResultRequest;
use App\Http\Requests\API\RMCalculatorRequest;
use App\Models\Question;
use App\Models\UserRmCalculator;
use App\Services\API\QuestionnaireService;
use App\Traits\ApiResponse;

class QuestionnaireController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        \request()->headers->set('Accept','application/json');
    }


    public function getAllQuestionnaire()
    {
        try {
            $result = Question::with('answers')->withTranslation(app()->getLocale())->get();
            return $this->success(" ",$result);
        }catch (\Exception $e){
            return $this->error("");
        }
    }


    public function questionnaireCalculation(questionnaireResultRequest $request, QuestionnaireService $service)
    {
        try {
            return $service->questionnaireCalculation($request);
        }catch (\Exception $e){
            return $this->error("");
        }
    }

    public function rmCalculator(RMCalculatorRequest $request)
    {
        UserRmCalculator::where('user_id',auth()->guard('user-api')->user()->id)->delete();
        $liftWeight  = $request->lift_weight;
        $repetitions = $request->repetitions;
        $rm = floatval($liftWeight / ((100 - ($repetitions * 2.5)) / 100));
        $rm = round($rm,2);
        UserRmCalculator::create([
                'user_id'  => auth()->guard('user-api')->user()->id,
                'percent'  => 100,
                'one_rm'   => round($rm, 2)]);
        $percent = 100;
        for ($i = 0; $i < 10; $i++)
        {
            $percent = $percent - 5;
            $newRm = ($percent * $rm) / 100;
            UserRmCalculator::create([
               'user_id'  => auth()->guard('user-api')->user()->id,
               'percent'  => $percent,
               'one_rm'   => round($newRm, 2),
              ]);
        }
        $data = UserRmCalculator::where('user_id',auth()->guard('user-api')->user()->id)->orderBy('percent','desc')->get();
        return $this->success(" ",$data);
    }

    public function getRmCalculator()
    {
        $data = UserRmCalculator::where('user_id',auth()->guard('user-api')->user()->id)->orderBy('percent','desc')->get();
        return $this->success(" ",$data);
    }
}
