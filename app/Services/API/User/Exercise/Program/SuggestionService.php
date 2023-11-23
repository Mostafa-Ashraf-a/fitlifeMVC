<?php


namespace App\Services\API\User\Exercise\Program;


use App\Models\DayFive;
use App\Models\DayFour;
use App\Models\DayOne;
use App\Models\DaySeven;
use App\Models\DaySix;
use App\Models\DayThree;
use App\Models\DayTwo;
use App\Models\Exercise;
use App\Models\Workout;
use App\Models\WorkoutType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SuggestionService
{
    const PROGRAM_DAILY_DURATION = 1;
    const PROGRAM_WEEKLY_DURATION = 2;
    public function store($request, $user) : bool
    {
        DB::table('user_exercise_suggestion')->where('user_id',$user->id)->delete();
        DB::table('user_exercise_program_suggestions')->where('user_id',$user->id)->delete();
        $this->workoutMatching($request, $user);
        $day = DB::table('user_exercise_suggestion')->where('user_id',$user->id)->first();
        if($day != null) {
            return true;
        }
        return false;
    }

    private function workoutMatching($request, $user)
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

    public function insertData($normalResult, $request, $user) : bool
    {
        if($request->exercise_status != 1)
        {
            $generalResult = Workout::query()
                ->where('type_id','=',16)
                ->latest()
                ->get();
            $this->generalNormalType($generalResult, $user, $normalResult);
        }
        else
        {
            $this->normalType($normalResult, $user);
        }
        return true;
    }

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
                        'start_at'    => Carbon::now('Asia/Riyadh')->addDays($count + $j + $n + $out)->format('Y-m-d'),
                        'end_at'      => Carbon::now('Asia/Riyadh')->addDays($count + $j + $n + 1 + $out)->format('Y-m-d')
                    ]);
                }
                $count +=1;
                $n +=6;
            }
            $out += $repetition * 7;
        }
    }

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
                        'start_at'    => Carbon::now('Asia/Riyadh')->addDays($count + $j + $n + $out)->format('Y-m-d'),
                        'end_at'      => Carbon::now('Asia/Riyadh')->addDays($count + $j + $n + 1 + $out)->format('Y-m-d')
                    ]);
                }
                $count +=1;
                $n +=6;
            }
            $out += $repetition * 7;
        }
    }

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
                            'start_at'    => Carbon::createFromFormat('Y-m-d', $countGeneralDays->end_at)->addDays($count + $j + $n + $out)->format('Y-m-d'),
                            'end_at'      => Carbon::createFromFormat('Y-m-d', $countGeneralDays->end_at)->addDays($count + $j + $n + 1 + $out)->format('Y-m-d')

                        ]);
                    }
                    $count +=1;
                    $n +=6;
                }
                $out += $repetition * 7;
            }
        }
    }

    public function insertIntoDailyRunningProgram()
    {
        $user = auth()->guard('user-api')->user();
        $now = Carbon::now('Asia/Riyadh')->format('Y-m-d');
        $checkProgram = DB::table('user_exercise_program_suggestions')
            ->where('user_id', $user->id)
            ->whereDate('start_at','<=',$now)
            ->whereDate('end_at','>=',$now)
            ->where('program_duration',1)
            ->first();
        $this->checkLastDailyProgram($user, $now);
        if(!isset($checkProgram))
        {
            $data = DB::table('user_exercise_suggestion')
                ->where('user_id', $user->id)
                ->whereDate('start_at','<=',$now)
                ->whereDate('end_at','>=',$now)
                ->first();
            if($data != null)
            {
                if($data->day == 1)
                {
                    $dayOne = DayOne::where('workout_id',$data->workout_id)->get();
                    foreach ($dayOne as $row)
                    {
                        $exercise = Exercise::where('id',$row['exercise_id'])->first();
                        DB::table('user_exercise_program_suggestions')->insert([
                            'user_id'               => $user->id,
                            'day_id'                => 1,
                            'body_part_id'          => $exercise->muscle_id,
                            'exercise_id'           => $exercise->id,
                            'exercise_type_id'      => $exercise->exercise_category,
                            'start_at'              => $data->start_at,
                            'end_at'                => $data->end_at,
                            'program_duration'      => self::PROGRAM_DAILY_DURATION
                        ]);
                    }
                }
                elseif ($data->day == 2)
                {
                    $dayTwo = DayTwo::where('workout_id',$data->workout_id)->get();
                    foreach ($dayTwo as $row)
                    {
                        $exercise = Exercise::where('id',$row['exercise_id'])->first();
                        DB::table('user_exercise_program_suggestions')->insert([
                            'user_id'               => $user->id,
                            'day_id'                => 2,
                            'body_part_id'          => $exercise->muscle_id,
                            'exercise_id'           => $exercise->id,
                            'exercise_type_id'      => $exercise->exercise_category,
                            'start_at'              => $data->start_at,
                            'end_at'                => $data->end_at,
                            'program_duration'      => self::PROGRAM_DAILY_DURATION
                        ]);
                    }
                }
                elseif ($data->day == 3)
                {
                    $dayThree = DayThree::where('workout_id',$data->workout_id)->get();
                    foreach ($dayThree as $row)
                    {
                        $exercise = Exercise::where('id',$row['exercise_id'])->first();
                        DB::table('user_exercise_program_suggestions')->insert([
                            'user_id'               => $user->id,
                            'day_id'                => 3,
                            'body_part_id'          => $exercise->muscle_id,
                            'exercise_id'           => $exercise->id,
                            'exercise_type_id'      => $exercise->exercise_category,
                            'start_at'              => $data->start_at,
                            'end_at'                => $data->end_at,
                            'program_duration'      => self::PROGRAM_DAILY_DURATION
                        ]);
                    }
                }
                elseif ($data->day == 4)
                {
                    $dayFour = DayFour::where('workout_id',$data->workout_id)->get();
                    foreach ($dayFour as $row)
                    {
                        $exercise = Exercise::where('id',$row['exercise_id'])->first();
                        DB::table('user_exercise_program_suggestions')->insert([
                            'user_id'               => $user->id,
                            'day_id'                => 4,
                            'body_part_id'          => $exercise->muscle_id,
                            'exercise_id'           => $exercise->id,
                            'exercise_type_id'      => $exercise->exercise_category,
                            'start_at'              => $data->start_at,
                            'end_at'                => $data->end_at,
                            'program_duration'      => self::PROGRAM_DAILY_DURATION
                        ]);
                    }
                }
                elseif ($data->day == 5)
                {
                    $dayFive = DayFive::where('workout_id',$data->workout_id)->get();
                    foreach ($dayFive as $row)
                    {
                        $exercise = Exercise::where('id',$row['exercise_id'])->first();
                        DB::table('user_exercise_program_suggestions')->insert([
                            'user_id'               => $user->id,
                            'day_id'                => 5,
                            'body_part_id'          => $exercise->muscle_id,
                            'exercise_id'           => $exercise->id,
                            'exercise_type_id'      => $exercise->exercise_category,
                            'start_at'              => $data->start_at,
                            'end_at'                => $data->end_at,
                            'program_duration'      => self::PROGRAM_DAILY_DURATION
                        ]);
                    }
                }
                elseif ($data->day == 6)
                {
                    $daySix = DaySix::where('workout_id',$data->workout_id)->get();
                    foreach ($daySix as $row)
                    {
                        $exercise = Exercise::where('id',$row['exercise_id'])->first();
                        DB::table('user_exercise_program_suggestions')->insert([
                            'user_id'               => $user->id,
                            'day_id'                => 6,
                            'body_part_id'          => $exercise->muscle_id,
                            'exercise_id'           => $exercise->id,
                            'exercise_type_id'      => $exercise->exercise_category,
                            'start_at'              => $data->start_at,
                            'end_at'                => $data->end_at,
                            'program_duration'      => self::PROGRAM_DAILY_DURATION
                        ]);
                    }
                }
                else
                {
                    $daySeven = DaySeven::where('workout_id',$data->workout_id)->get();
                    foreach ($daySeven as $row)
                    {
                        $exercise = Exercise::where('id',$row['exercise_id'])->first();
                        DB::table('user_exercise_program_suggestions')->insert([
                            'user_id'               => $user->id,
                            'day_id'                => 7,
                            'body_part_id'          => $exercise->muscle_id,
                            'exercise_id'           => $exercise->id,
                            'exercise_type_id'      => $exercise->exercise_category,
                            'start_at'              => $data->start_at,
                            'end_at'                => $data->end_at,
                            'program_duration'      => self::PROGRAM_DAILY_DURATION
                        ]);
                    }
                }
            }
        }
    }

    public function insertIntoWeeklyRunningProgram()
    {
        $user = auth()->guard('user-api')->user();
        $today = Carbon::today('Asia/Riyadh')->format('Y-m-d');
        $end = Carbon::today('Asia/Riyadh')->addDays(6)->format('Y-m-d');
        $checkLast = DB::table('user_exercise_program_suggestions')
            ->where('user_id', auth()->guard('user-api')->user()->id)
            ->where('program_duration', 2)
            ->orderBy('id','DESC')
            ->first();
        if((isset($checkLast) && $checkLast->end_at == $today) || empty($checkLast))
        {
            $days = DB::table('user_exercise_suggestion')
                ->where('user_id', $user->id)
                ->whereBetween('start_at', [$today, $end])
                ->get();
            foreach ($days as $day)
            {
                if($day->day == 1)
                {
                    $dayOne = DayOne::where('workout_id',$day->workout_id)->get();
                    foreach ($dayOne as $row)
                    {
                        $exercise = Exercise::where('id',$row['exercise_id'])->first();
                        DB::table('user_exercise_program_suggestions')->insert([
                            'user_id'               => $user->id,
                            'day_id'                => 1,
                            'body_part_id'          => $exercise->muscle_id,
                            'exercise_id'           => $exercise->id,
                            'exercise_type_id'      => $exercise->exercise_category,
                            'start_at'              => $day->start_at,
                            'end_at'                => $day->end_at,
                            'program_duration'      => self::PROGRAM_WEEKLY_DURATION
                        ]);
                    }
                }
                elseif ($day->day == 2)
                {
                    $dayTwo = DayTwo::where('workout_id',$day->workout_id)->get();
                    foreach ($dayTwo as $row)
                    {
                        $exercise = Exercise::where('id',$row['exercise_id'])->first();
                        DB::table('user_exercise_program_suggestions')->insert([
                            'user_id'               => $user->id,
                            'day_id'                => 2,
                            'body_part_id'          => $exercise->muscle_id,
                            'exercise_id'           => $exercise->id,
                            'exercise_type_id'      => $exercise->exercise_category,
                            'start_at'              => $day->start_at,
                            'end_at'                => $day->end_at,
                            'program_duration'      => self::PROGRAM_WEEKLY_DURATION
                        ]);
                    }
                }
                elseif ($day->day == 3)
                {
                    $dayThree = DayThree::where('workout_id',$day->workout_id)->get();
                    foreach ($dayThree as $row)
                    {
                        $exercise = Exercise::where('id',$row['exercise_id'])->first();
                        DB::table('user_exercise_program_suggestions')->insert([
                            'user_id'               => $user->id,
                            'day_id'                => 3,
                            'body_part_id'          => $exercise->muscle_id,
                            'exercise_id'           => $exercise->id,
                            'exercise_type_id'      => $exercise->exercise_category,
                            'start_at'              => $day->start_at,
                            'end_at'                => $day->end_at,
                            'program_duration'      => self::PROGRAM_WEEKLY_DURATION
                        ]);
                    }
                }
                elseif ($day->day == 4)
                {
                    $dayFour = DayFour::where('workout_id',$day->workout_id)->get();
                    foreach ($dayFour as $row)
                    {
                        $exercise = Exercise::where('id',$row['exercise_id'])->first();
                        DB::table('user_exercise_program_suggestions')->insert([
                            'user_id'               => $user->id,
                            'day_id'                => 4,
                            'body_part_id'          => $exercise->muscle_id,
                            'exercise_id'           => $exercise->id,
                            'exercise_type_id'      => $exercise->exercise_category,
                            'start_at'              => $day->start_at,
                            'end_at'                => $day->end_at,
                            'program_duration'      => self::PROGRAM_WEEKLY_DURATION
                        ]);
                    }
                }
                elseif ($day->day == 5)
                {
                    $dayFive = DayFive::where('workout_id',$day->workout_id)->get();
                    foreach ($dayFive as $row)
                    {
                        $exercise = Exercise::where('id',$row['exercise_id'])->first();
                        DB::table('user_exercise_program_suggestions')->insert([
                            'user_id'               => $user->id,
                            'day_id'                => 5,
                            'body_part_id'          => $exercise->muscle_id,
                            'exercise_id'           => $exercise->id,
                            'exercise_type_id'      => $exercise->exercise_category,
                            'start_at'              => $day->start_at,
                            'end_at'                => $day->end_at,
                            'program_duration'      => self::PROGRAM_WEEKLY_DURATION
                        ]);
                    }
                }
                elseif ($day->day == 6)
                {
                    $daySix = DaySix::where('workout_id',$day->workout_id)->get();
                    foreach ($daySix as $row)
                    {
                        $exercise = Exercise::where('id',$row['exercise_id'])->first();
                        DB::table('user_exercise_program_suggestions')->insert([
                            'user_id'               => $user->id,
                            'day_id'                => 6,
                            'body_part_id'          => $exercise->muscle_id,
                            'exercise_id'           => $exercise->id,
                            'exercise_type_id'      => $exercise->exercise_category,
                            'start_at'              => $day->start_at,
                            'end_at'                => $day->end_at,
                            'program_duration'      => self::PROGRAM_WEEKLY_DURATION
                        ]);
                    }
                }
                else
                {
                    $daySeven = DaySeven::where('workout_id',$day->workout_id)->get();
                    foreach ($daySeven as $row)
                    {
                        $exercise = Exercise::where('id',$row['exercise_id'])->first();
                        DB::table('user_exercise_program_suggestions')->insert([
                            'user_id'               => $user->id,
                            'day_id'                => 7,
                            'body_part_id'          => $exercise->muscle_id,
                            'exercise_id'           => $exercise->id,
                            'exercise_type_id'      => $exercise->exercise_category,
                            'start_at'              => $day->start_at,
                            'end_at'                => $day->end_at,
                            'program_duration'      => self::PROGRAM_WEEKLY_DURATION
                        ]);
                    }
                }
            }
        }
    }

    private function checkLastDailyProgram($user, $now)
    {
        $check = DB::table('user_exercise_suggestion')
            ->where('user_id', $user->id)
            ->get();
        $checkLast = DB::table('user_exercise_suggestion')
            ->where('user_id', $user->id)
            ->whereDate('end_at','<',$now)
            ->latest('id')
            ->first();
        if($checkLast)
        {
            $this->updateExerciseDates($check);
        }
    }

    public function updateExerciseDates($check) : bool
    {
        $i = 0;
        foreach ($check as $value)
        {
            DB::table('user_exercise_suggestion')
                ->where('id', $value->id)
                ->update([
                    'start_at'    => Carbon::now('Asia/Riyadh')->addDays($i)->format('Y-m-d'),
                    'end_at'      => Carbon::now('Asia/Riyadh')->addDays($i + 1)->format('Y-m-d')
                ]);
            $i++;
        }
        return true;
    }
}
