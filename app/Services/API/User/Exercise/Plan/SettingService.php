<?php


namespace App\Services\API\User\Exercise\Plan;


use App\Models\ExerciseDaySetting;
use App\Models\UserExerciseDaySetting;

class SettingService
{
    /**
     * @param $request
     */
    public function store($request) : void
    {
        if(isset($request->exercise_id))
        {
            $this->storeExerciseSetting($request);
        }else{
            $this->storeDaySetting($request);
        }
    }

    /**
     * @param $request
     */
    private function storeExerciseSetting($request): void
    {
        UserExerciseDaySetting::updateOrCreate(
            ['user_id' => auth()->guard('user-api')->user()->id, 'day' => $request->day, 'exercise_id' => $request->exercise_id],
            [
                'user_id'     => auth()->guard('user-api')->user()->id,
                'exercise_id' => $request->exercise_id,
                'day'         => $request->day,
                'rest'        => $request->rest,
                'sets'        => $request->sets,
                'reps'        => $request->reps
            ]
        );
    }

    /**
     * @param $request
     */
    private function storeDaySetting($request): void
    {
        ExerciseDaySetting::updateOrCreate(
            ['user_id' => auth()->guard('user-api')->user()->id, 'day' => $request->day],
            [
                'user_id'  => auth()->guard('user-api')->user()->id,
                'day'      => $request->day,
                'rest'     => $request->rest,
                'sets'     => $request->sets,
                'reps'     => $request->reps
            ]
        );
    }
}
