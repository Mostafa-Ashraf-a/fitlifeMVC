<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UserExercisePlanRequest;
use App\Http\Resources\ExerciseSettingResource;
use App\Models\Day;
use App\Models\Exercise;
use App\Models\ExerciseDaySetting;
use App\Models\User;
use App\Models\UserExerciseDaySetting;
use App\Traits\ApiResponse;
use App\Http\Resources\UserExercisePlan as PlanResource;
use Illuminate\Support\Facades\DB;

class UserExercisePlanController extends Controller
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
        $plan = User::with('day.muscle.exercises')
            ->where('id',auth()->guard('user-api')->user()->id)
            ->first();
        return $this->success(" ",PlanResource\UserPlanResource::make($plan));
    }

    public function show($id)
    {
        $result = Exercise::findOrFail($id);
        return $this->success(" ",new ExerciseSettingResource($result));
    }

    public function store(UserExercisePlanRequest $request)
    {
        $user = User::find(auth()->guard('user-api')->user()->id);
        foreach ($request->exercises as $exercise)
        {
            $model = Exercise::where('id',$exercise['exercise_id'])->first();
            $dayModel = Day::where('day',$request->day)->first();
            if(!$model){
                return $this->error("Exercise Not Found",404);
            }
            $check = DB::table('user_days')
                ->where('day_id',$dayModel->id)
                ->where('user_id',$user->id)
                ->where('exercise_id',$model->id)
                ->where('body_part_id', $model->muscle_id)
                ->first();

            if(isset($check))
            {
                return $this->error("The plan Is already added",400);
            }

            DB::table('user_days')->where('day_id',$dayModel->id)
                ->where('user_id',$user->id)
                ->where('exercise_id','=',NULL)
                ->where('body_part_id', '=',NULL)
                ->delete();

                DB::table('user_days')->insert([
                'user_id'       => $user->id,
                'exercise_id'   => $model->id,
                'body_part_id'  => $model->muscle_id,
                'day_id'        => $dayModel->id,
            ]);
        }
            return $this->success(" ",true);
    }



    /**
     * @param $dayId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($dayId)
    {
        $day = Day::findOrFail($dayId);
        $exerciseId = \request()->query('exercise_id');
        $reset = \request()->query('reset');
        $status = 0;

        if($day && $exerciseId)
        {
            $exercise = Exercise::findOrFail($exerciseId);
            $status = DB::table('user_days')
                ->where('day_id',$day->id)
                ->where('exercise_id',$exercise->id)
                ->where('user_id',auth()->guard('user-api')->user()->id)
                ->update([
                    'exercise_id'   => NULL,
                    'body_part_id'  => NULL
                ]);

            UserExerciseDaySetting::where(
                [
                    'user_id'     => auth()->guard('user-api')->user()->id,
                    'day'         => $day->id,
                    'exercise_id' => $exerciseId
                ],
            )->delete();
        }
        if($day && ($reset == 1))
        {
            $status = DB::table('user_days')
                ->where('day_id',$day->id)
                ->where('user_id',auth()->guard('user-api')->user()->id)
                ->update([
                    'exercise_id'   => NULL,
                    'body_part_id'  => NULL
                ]);

            ExerciseDaySetting::where(
                [
                    'user_id' => auth()->guard('user-api')->user()->id,
                    'day'     => $day->id
                ],
            )->delete();

        }
        return $this->success(" ", ($status != 0));
    }

}
