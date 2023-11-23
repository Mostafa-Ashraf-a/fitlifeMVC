<?php


namespace App\Services\Dashboard;


use App\Models\DayExerciseBodyPart;
use App\Models\DayExerciseType;
use App\Models\DayFive;
use App\Models\DayFour;
use App\Models\DayOne;
use App\Models\DaySeven;
use App\Models\DaySix;
use App\Models\DayThree;
use App\Models\DayTwo;
use App\Models\Workout;
use App\Traits\Photoable;

class WorkoutService
{
    use Photoable;

    /**
     * @param $request
     */
    public function store($request) : void
    {
        if ($request->workout_id) {
            $workout = Workout::findOrFail($request->workout_id);
        } else {
            $workout = $this->storeWorkout($request);
        }

        if ($request->hasFile('image'))
        {
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$workout->id, 'workouts/images/');
            $workout->update([
                'image' => $fileName
            ]);
        }
        $this->workoutDay1($request,$workout);
        $this->workoutDay2($request,$workout);
        $this->workoutDay3($request,$workout);
        $this->workoutDay4($request,$workout);
        $this->workoutDay5($request,$workout);
        $this->workoutDay6($request,$workout);
        $this->workoutDay7($request,$workout);
    }

    /**
     * @param $request
     * @return mixed
     */
    private function storeWorkout($request) : mixed
    {
        return  Workout::create([
            'title'             => $request->title,
            'description'       => $request->description,
            'goal_id'           => $request->goal_id,
            'level_id'          => $request->level_id,
            'type_id'           => $request->type_id,
            'place_type'        => $request->place_type,
        ]);
    }

    private function workoutDay1($request,$workout)
    {
        if(isset($request->exercise_day_1) && isset($request->body_part_day_1) && isset($request->exercise_type_day_1))
        {
            foreach ($request->exercise_day_1 as $key => $value)
            {
                DayOne::create(['exercise_id'=> $value, 'workout_id' =>  $workout->id, 'exercise_type' => $request->exercise_type_day_1[$key]]);
            }

            foreach ($request->body_part_day_1 as $bodyPartDay1)
            {
                DayExerciseBodyPart::create(['day'=> 1,'body_part_id'=>$bodyPartDay1, 'workout_id' =>  $workout->id]);
            }
            foreach ($request->exercise_type_day_1 as $typeDay1)
            {
                DayExerciseType::create(['day'=> 1,'type'=>$typeDay1, 'workout_id' =>  $workout->id]);
            }
        }
    }

    private function workoutDay2($request,$workout)
    {
        if(isset($request->exercise_day_2) && isset($request->body_part_day_2) && isset($request->exercise_type_day_2))
        {
            foreach ($request->exercise_day_2 as $key => $value)
            {
                DayTwo::create(['exercise_id'=> $value, 'workout_id' =>  $workout->id,  'exercise_type' => $request->exercise_type_day_2[$key]]);
            }

            foreach ($request->exercise_type_day_2 as $typeDay2)
            {
                DayExerciseType::create(['day'=> 2,'type'=>$typeDay2, 'workout_id' =>  $workout->id]);
            }

            foreach ($request->body_part_day_2 as $bodyPartDay2)
            {
                DayExerciseBodyPart::create(['day'=> 2,'body_part_id'=>$bodyPartDay2, 'workout_id' =>  $workout->id]);
            }
        }
    }

    private function workoutDay3($request,$workout)
    {
        if(isset($request->exercise_day_3) && isset($request->body_part_day_3) && isset($request->exercise_type_day_3))
        {
            foreach ($request->exercise_day_3 as $key => $value)
            {
                DayThree::create(['exercise_id'=> $value, 'workout_id' =>  $workout->id, 'exercise_type' => $request->exercise_type_day_3[$key]]);
            }

            foreach ($request->exercise_type_day_3 as $typeDay3)
            {
                DayExerciseType::create(['day'=> 3,'type'=>$typeDay3, 'workout_id' =>  $workout->id]);
            }

            foreach ($request->body_part_day_3 as $bodyPartDay3)
            {
                DayExerciseBodyPart::create(['day'=> 3,'body_part_id'=>$bodyPartDay3, 'workout_id' =>  $workout->id]);
            }
        }
    }

    private function workoutDay4($request,$workout)
    {
        if(isset($request->exercise_day_4) && isset($request->body_part_day_4) && isset($request->exercise_type_day_4))
        {
            foreach ($request->exercise_day_4 as $key => $value)
            {
                DayFour::create(['exercise_id'=> $value, 'workout_id' =>  $workout->id, 'exercise_type' => $request->exercise_type_day_4[$key]]);
            }

            foreach ($request->exercise_type_day_4 as $typeDay4)
            {
                DayExerciseType::create(['day'=> 4,'type'=>$typeDay4, 'workout_id' =>  $workout->id]);
            }

            foreach ($request->body_part_day_4 as $bodyPartDay4)
            {
                DayExerciseBodyPart::create(['day'=> 4,'body_part_id'=>$bodyPartDay4, 'workout_id' =>  $workout->id]);
            }
        }
    }

    private function workoutDay5($request,$workout)
    {
        if(isset($request->exercise_day_5) && isset($request->body_part_day_5) && isset($request->exercise_type_day_5))
        {
            foreach ($request->exercise_day_5 as $key => $value)
            {
                DayFive::create(['exercise_id'=> $value, 'workout_id' =>  $workout->id, 'exercise_type' => $request->exercise_type_day_5[$key]]);
            }

            foreach ($request->exercise_type_day_5 as $typeDay5)
            {
                DayExerciseType::create(['day'=> 5,'type'=>$typeDay5, 'workout_id' =>  $workout->id]);
            }

            foreach ($request->body_part_day_5 as $bodyPartDay5)
            {
                DayExerciseBodyPart::create(['day'=> 5,'body_part_id'=>$bodyPartDay5, 'workout_id' =>  $workout->id]);
            }
        }
    }

    private function workoutDay6($request,$workout)
    {
        if(isset($request->exercise_day_6) && isset($request->body_part_day_6) && isset($request->exercise_type_day_6))
        {
            foreach ($request->exercise_day_6 as $key => $value)
            {
                DaySix::create(['exercise_id'=> $value, 'workout_id' =>  $workout->id, 'exercise_type' => $request->exercise_type_day_6[$key]]);
            }

            foreach ($request->exercise_type_day_6 as $typeDay6)
            {
                DayExerciseType::create(['day'=> 6,'type'=>$typeDay6, 'workout_id' =>  $workout->id]);
            }

            foreach ($request->body_part_day_6 as $bodyPartDay6)
            {
                DayExerciseBodyPart::create(['day'=> 6,'body_part_id'=>$bodyPartDay6, 'workout_id' =>  $workout->id]);
            }
        }
    }

    private function workoutDay7($request,$workout)
    {
        if(isset($request->exercise_day_7) && isset($request->body_part_day_7) && isset($request->exercise_type_day_7))
        {
            foreach ($request->exercise_day_7 as $key => $value)
            {
                DaySeven::create(['exercise_id'=> $value, 'workout_id' =>  $workout->id, 'exercise_type' => $request->exercise_type_day_7[$key]]);
            }

            foreach ($request->exercise_type_day_7 as $typeDay7)
            {
                DayExerciseType::create(['day'=> 7,'type'=>$typeDay7, 'workout_id' =>  $workout->id]);
            }

            foreach ($request->body_part_day_7 as $bodyPartDay7)
            {
                DayExerciseBodyPart::create(['day'=> 7,'body_part_id'=>$bodyPartDay7, 'workout_id' =>  $workout->id]);
            }
        }
    }
}
