<?php


namespace App\Services\API;


use App\Http\Resources\WorkoutResource;
use App\Models\Workout;
use App\Models\WorkoutType;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ExerciseProgramSuggestionService
{
    use ApiResponse;
    /**
     * @param $request
     * @param $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function exerciseResult($request, $user)
    {
        DB::table('user_exercise_suggestion')->where('user_id',$user->id)->delete();
        $this->requestResult($request, $user);
        $day = DB::table('user_exercise_suggestion')->where('user_id',$user->id)->first();
        if($day != null) {
            return $this->success(" ",true);
        }
        return $this->error("There are no programs matching the input");
    }

    /**
     * @param $request
     * @param $user
     * @return bool
     */
    public function requestResult($request, $user)
    {
        $workout = Workout::query();
        if($request->place_type == 1)
        {
            if($request->days == 2)
            {
                if($user->level == 8)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',1);
                }
                elseif ($user->level == 9)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',2);
                }
                elseif ($user->level == 10)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',3);
                }
            }

            if($request->days == 3)
            {
                if($user->level == 8)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',4);
                }
                elseif ($user->level == 9)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',5);
                }
                elseif ($user->level == 10)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',6);
                }
            }

            if($request->days == 4)
            {
                if($user->level == 8)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',7);
                }
                elseif ($user->level == 9)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',8);
                }
                elseif ($user->level == 10)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',9);
                }
            }

            if($request->days == 5)
            {
                if($user->level == 8)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',10);
                }
                elseif ($user->level == 9)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',11);
                }
                elseif ($user->level == 10)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',12);
                }
            }

            if($request->days == 6)
            {
                if($user->level == 8)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',13);
                }
                elseif ($user->level == 9)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',14);
                }
                elseif ($user->level == 10)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',15);
                }
            }
        }
        else
        {
            if($request->days == 2)
            {
                if($user->level == 8)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',1);
                }
                elseif ($user->level == 9)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',2);
                }
                elseif ($user->level == 10)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',3);
                }
            }

            if($request->days == 3)
            {
                if($user->level == 8)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',4);
                }
                elseif ($user->level == 9)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',5);
                }
                elseif ($user->level == 10)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',6);
                }
            }

            if($request->days == 4)
            {
                if($user->level == 8)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',7);
                }
                elseif ($user->level == 9)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',8);
                }
                elseif ($user->level == 10)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',9);
                }
            }

            if($request->days == 5)
            {
                if($user->level == 8)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',10);
                }
                elseif ($user->level == 9)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',11);
                }
                elseif ($user->level == 10)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',12);
                }
            }

            if($request->days == 6)
            {
                if($user->level == 8)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',13);
                }
                elseif ($user->level == 9)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',14);
                }
                elseif ($user->level == 10)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',15);
                }
            }
        }
        $result = $workout->get();
        $this->insertData($result, $request, $user);
        return true;
    }

    /**
     * @param $normalResult
     * @param $request
     * @param $user
     * @return bool
     */
    public function insertData($normalResult, $request, $user) : bool
    {
        if($request->exercise_status != 1)
        {
            $generalResult = Workout::query()
                ->where('type_id','=',16)
                ->latest()
                ->get();
            $this->generalNormalType($generalResult, $user, $normalResult);
        }else{
            $this->normalType($normalResult, $user);
        }
        return true;
    }

    /**
     * @param $result
     * @param $user
     */
    public function normalType($result, $user) : void
    {
        $out = 0;
        foreach ($result as $row)
        {
            $count = 0;
            $n = 0;
            $type = WorkoutType::findOrFail($row->type_id);
            $repetition = $type->repetition;
            for ($i = 0; $i < $repetition; $i++)
            {
                for ($j = 0; $j < 7; $j++)
                {
                    DB::table('user_exercise_suggestion')->insert([
                        'user_id'     => $user->id,
                        'workout_id'  => $row['id'],
                        'day'         => $j + 1,
                        'start_at'    => Carbon::now('Asia/Riyadh')->addDays($count + $j + $n + $out)->format('Y-m-d H:i:s'),
                        'end_at'      => Carbon::now('Asia/Riyadh')->addDays($count + $j + $n + 1 + $out)->format('Y-m-d H:i:s')
                    ]);
                }
                $count +=1;
                $n +=6;
            }
            $out += $repetition * 7;
        }
    }

    /**
     * @param $generalResult
     * @param $user
     */
    public function generalType($generalResult, $user) : void
    {
        $out = 0;
        foreach ($generalResult as $row)
        {
            $count = 0;
            $n = 0;
            $type = WorkoutType::findOrFail($row->type_id);
            $repetition = $type->repetition;
            for ($i = 0; $i < $repetition; $i++)
            {
                for ($j = 0; $j < 7; $j++)
                {
                    DB::table('user_exercise_suggestion')->insert([
                        'user_id'     => $user->id,
                        'workout_id'  => $row['id'],
                        'day'         => $j + 1,
                        'start_at'    => Carbon::now('Asia/Riyadh')->addDays($count + $j + $n + $out)->format('Y-m-d H:i:s'),
                        'end_at'      => Carbon::now('Asia/Riyadh')->addDays($count + $j + $n + 1 + $out)->format('Y-m-d H:i:s')
                    ]);
                }
                $count +=1;
                $n +=6;
            }
            $out += $repetition * 7;
        }
    }

    /**
     * @param $generalResult
     * @param $user
     * @param $normalResult
     */
    public function generalNormalType($generalResult, $user, $normalResult) : void
    {
        $this->generalType($generalResult, $user);
        $countGeneralDays = DB::table('user_exercise_suggestion')->where('user_id',$user->id)
            ->select('end_at')->orderBy('id', 'desc')->first();
        if(!empty($countGeneralDays))
        {
            $out = 0;
            foreach ($normalResult as $row)
            {
                $count = 0;
                $n = 0;
                $type = WorkoutType::findOrFail($row->type_id);
                $repetition = $type->repetition;
                for ($i = 0; $i < $repetition; $i++)
                {
                    for ($j = 0; $j < 7; $j++)
                    {
                        DB::table('user_exercise_suggestion')->insert([
                            'user_id'     => $user->id,
                            'workout_id'  => $row['id'],
                            'day'         => $j + 1,
                            'start_at'    => Carbon::createFromFormat('Y-m-d H:i:s', $countGeneralDays->end_at)->addDays($count + $j + $n + $out)->format('Y-m-d H:i:s'),
                            'end_at'      => Carbon::createFromFormat('Y-m-d H:i:s', $countGeneralDays->end_at)->addDays($count + $j + $n + 1 + $out)->format('Y-m-d H:i:s')

                        ]);
                    }
                    $count +=1;
                    $n +=6;
                }
                $out += $repetition * 7;
            }
        }
    }


    public function exerciseResultOld($request, $user)
    {
        DB::table('user_exercise_suggestion')->where('user_id',$user->id)->delete();
        $workout = Workout::query()->with(['dayOne','dayTwo','dayThree','dayFour','dayFive','daySix','daySeven']);
        if($request->place_type == 1)
        {
            if($request->days == 2)
            {
                if($user->level == 8)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',1);
                }
                elseif ($user->level == 9)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',2);
                }
                elseif ($user->level == 10)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',3);
                }
            }

            if($request->days == 3)
            {
                if($user->level == 8)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',4);
                }
                elseif ($user->level == 9)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',5);
                }
                elseif ($user->level == 10)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',6);
                }
            }

            if($request->days == 4)
            {
                if($user->level == 8)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',7);
                }
                elseif ($user->level == 9)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',8);
                }
                elseif ($user->level == 10)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',9);
                }
            }

            if($request->days == 5)
            {
                if($user->level == 8)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',10);
                }
                elseif ($user->level == 9)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',11);
                }
                elseif ($user->level == 10)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',12);
                }
            }

            if($request->days == 6)
            {
                if($user->level == 8)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',13);
                }
                elseif ($user->level == 9)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',14);
                }
                elseif ($user->level == 10)
                {
                    $workout->where('place_type',1)
                        ->where('type_id',15);
                }
            }
        }
        else
        {
            if($request->days == 2)
            {
                if($user->level == 8)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',1);
                }
                elseif ($user->level == 9)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',2);
                }
                elseif ($user->level == 10)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',3);
                }
            }

            if($request->days == 3)
            {
                if($user->level == 8)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',4);
                }
                elseif ($user->level == 9)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',5);
                }
                elseif ($user->level == 10)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',6);
                }
            }

            if($request->days == 4)
            {
                if($user->level == 8)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',7);
                }
                elseif ($user->level == 9)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',8);
                }
                elseif ($user->level == 10)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',9);
                }
            }

            if($request->days == 5)
            {
                if($user->level == 8)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',10);
                }
                elseif ($user->level == 9)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',11);
                }
                elseif ($user->level == 10)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',12);
                }
            }

            if($request->days == 6)
            {
                if($user->level == 8)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',13);
                }
                elseif ($user->level == 9)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',14);
                }
                elseif ($user->level == 10)
                {
                    $workout->where('place_type',2)
                        ->where('type_id',15);
                }
            }
        }
        $result = $workout->latest()->get();
        $result2 = null;
        if($request->exercise_status != 1)
        {
            $result2 = Workout::query()
                ->with(['dayOne','dayTwo','dayThree','dayFour','dayFive','daySix','daySeven'])
                ->where('type_id','=',16)
                ->latest()
                ->get();
        }
        if(($result->count() > 0) && ($result2 == null))
        {
            $out = 0;
            foreach ($result as $value)
            {
                $count = 0;
                $n = 0;
                for ($i = 0; $i < 2; $i++)
                {
                    if($result->count() == 1)
                    {
                        for ($j = 0; $j < 7; $j++)
                        {
                            DB::table('user_exercise_suggestion')->insert([
                                'user_id'     => $user->id,
                                'workout_id'  => $value['id'],
                                'day'         => $j + 1,
                                'start_at'    => Carbon::now('Asia/Riyadh')->addDays($count + $j + $n + $out)->format('Y-m-d H:i:s'),
                                'end_at'      => Carbon::now('Asia/Riyadh')->addDays($count + $j + $n + 1 + $out)->format('Y-m-d H:i:s')
                            ]);
                        }
                    }else{
                        for ($j = 0; $j < 7; $j++)
                        {
                            DB::table('user_exercise_suggestion')->insert([
                                'user_id'     => $user->id,
                                'workout_id'  => $value['id'],
                                'day'         => $j + 1,
                                'start_at'    => Carbon::now('Asia/Riyadh')->addDays($count + $j + $n + $out)->format('Y-m-d H:i:s'),
                                'end_at'      => Carbon::now('Asia/Riyadh')->addDays($count + $j + $n + 1 + $out)->format('Y-m-d H:i:s')
                            ]);
                        }
                    }
                    $count +=1;
                    $n +=7;
                }
                $out +=16;
            }
            $day = DB::table('user_exercise_suggestion')->first();
            $data = Workout::query()->with('dayOne')->findOrFail($day->workout_id);
            return $this->success(" ", WorkoutResource::make($data));
        }
        elseif(($result != null) && ($result2 != null))
        {
            $out2 = 0;
            foreach ($result2 as $value2)
            {
                $count2 = 0;
                $n2 = 0;
                for ($i = 0; $i < 2; $i++)
                {
                    if($result2->count() == 1)
                    {
                        for ($j = 0; $j < 7; $j++)
                        {
                            DB::table('user_exercise_suggestion')->insert([
                                'user_id'     => $user->id,
                                'workout_id'  => $value2['id'],
                                'day'         => $j + 1,
                                'start_at'    => Carbon::now('Asia/Riyadh')->addDays($count2 + $j + $n2 + $out2)->format('Y-m-d H:i:s'),
                                'end_at'      => Carbon::now('Asia/Riyadh')->addDays($count2 + $j + $n2 + 1 + $out2)->format('Y-m-d H:i:s')
                            ]);
                        }
                    }else{
                        for ($j = 0; $j < 7; $j++)
                        {
                            DB::table('user_exercise_suggestion')->insert([
                                'user_id'     => $user->id,
                                'workout_id'  => $value2['id'],
                                'day'         => $j + 1,
                                'start_at'    => Carbon::now('Asia/Riyadh')->addDays($count2 + $j + $n2 + $out2)->format('Y-m-d H:i:s'),
                                'end_at'      => Carbon::now('Asia/Riyadh')->addDays($count2 + $j + $n2 + 1 + $out2)->format('Y-m-d H:i:s')
                            ]);
                        }
                    }
                    $count2 +=1;
                    $n2 +=7;
                }
                $out2 +=16;
            }
            $countGeneralDays = DB::table('user_exercise_suggestion')->where('user_id',$user->id)
                ->select('end_at')->orderBy('id', 'desc')->first();

            $out3 = 0;
            foreach ($result as $value)
            {
                $count3 = 0;
                $n3 = 0;
                for ($i = 0; $i < 2; $i++)
                {
                    if($result->count() == 1)
                    {
                        for ($j = 0; $j < 7; $j++)
                        {
                            DB::table('user_exercise_suggestion')->insert([
                                'user_id'     => $user->id,
                                'workout_id'  => $value['id'],
                                'day'         => $j + 1,
                                'start_at'    => Carbon::createFromFormat('Y-m-d H:i:s', $countGeneralDays->end_at)->addDays($count3 + $j + $n3 + $out3)->format('Y-m-d H:i:s'),
                                'end_at'      => Carbon::createFromFormat('Y-m-d H:i:s', $countGeneralDays->end_at)->addDays($count3 + $j + $n3 + 1 + $out3)->format('Y-m-d H:i:s')

                            ]);
                        }
                    }else{
                        for ($j = 0; $j < 7; $j++)
                        {
                            DB::table('user_exercise_suggestion')->insert([
                                'user_id'     => $user->id,
                                'workout_id'  => $value['id'],
                                'day'         => $j + 1,
                                'start_at'    => Carbon::createFromFormat('Y-m-d H:i:s', $countGeneralDays->end_at)->addDays($count3 + $j + $n3 + $out3)->format('Y-m-d H:i:s'),
                                'end_at'      => Carbon::createFromFormat('Y-m-d H:i:s', $countGeneralDays->end_at)->addDays($count3 + $j + $n3 + 1 + $out3)->format('Y-m-d H:i:s')
                            ]);
                        }
                    }
                    $count3 +=1;
                    $n3 +=7;
                }
                $out3 +=16;
            }
            $day = DB::table('user_exercise_suggestion')->first();
            $data = Workout::query()->with('dayOne')->findOrFail($day->workout_id);
            return $this->success(" ", WorkoutResource::make($data));
        }else{
            return $this->error("There are no programs matching the input");
        }
    }
}
