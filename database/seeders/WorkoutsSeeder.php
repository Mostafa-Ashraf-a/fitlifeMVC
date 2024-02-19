<?php

namespace Database\Seeders;

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
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;


class WorkoutsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('workouts')->truncate();
        DB::table('day_ones')->truncate();
        DB::table('day_twos')->truncate();
        DB::table('day_threes')->truncate();
        DB::table('day_fours')->truncate();
        DB::table('day_fives')->truncate();
        DB::table('day_sixes')->truncate();
        DB::table('day_sevens')->truncate();
        DB::table('day_exercise_body_parts')->truncate();
        DB::table('day_exercise_types')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $workouts = config("exercises.workouts");
        $types = config("exercises.types");
        $exercises_types = [
            "Pre" => 1,
            "Main" => 2,
            "Post" => 3,
            "Cardio" => 4,
        ];
        $days = [
            "one" => 1,
            "two" => 2,
            "three" => 3,
            "four" => 4,
            "five" => 5,
            "six" => 6,
            "seven" => 7
        ];
        foreach ($workouts as $title => $data) {

            $workout = Workout::create([
                'title'             => $title,
                'description'       => $data["description"],
                'goal_id'           => $data["goal_id"],
                'level_id'          => $data["level_id"],
                'type_id'           => $data["type_id"],
                'place_type'        => $data["place_type"],
                'image'             => ""
            ]);

            // New Request Instance
            $request = new Request();

            //Images
            $image_name = "workouts/images/$workout->id.png";
            $image_file = public_path($image_name);

            if (file_exists($image_file)) {
                $image_uploaded = new UploadedFile($image_file, $image_name);
                $request->files->set('image', $image_uploaded);
                $image = $request->file('image');
            }

            if (file_exists($image_file)) {

                $extension_image = $image->getClientOriginalExtension();
                $fileNameImage = uniqid() . '-' . time() . '.' . $extension_image;
                $image_path = 'workouts/images/';
                $image->storeAs('files/' . $image_path . $workout->id . '/', $fileNameImage, 'public');
                Image::make(storage_path('app/public/files/' . $image_path . $workout->id . '/' . $fileNameImage))
                    ->save(storage_path('app/public/files/' . $image_path . $workout->id . '/thumb-' . $fileNameImage));

                $workout->update([
                    'image' => $fileNameImage,
                ]);
            }

            foreach ($data["days"] as $day => $exercises_data) {

                foreach ($exercises_data as $body_part_id => $exercises_ids) {

                    foreach ($exercises_ids as $exercises_id) {

                        if ($day == "one") {

                            DayOne::create([
                                'exercise_id' => $exercises_id,
                                'workout_id' =>  $workout->id,
                                'exercise_type' => $exercises_types[$types[$exercises_id]]
                            ]);
                        }

                        if ($day == "two") {

                            DayTwo::create([
                                'exercise_id' => $exercises_id,
                                'workout_id' =>  $workout->id,
                                'exercise_type' => $exercises_types[$types[$exercises_id]]
                            ]);
                        }

                        if ($day == "three") {

                            DayThree::create([
                                'exercise_id' => $exercises_id,
                                'workout_id' =>  $workout->id,
                                'exercise_type' => $exercises_types[$types[$exercises_id]]
                            ]);
                        }

                        if ($day == "four") {

                            DayFour::create([
                                'exercise_id' => $exercises_id,
                                'workout_id' =>  $workout->id,
                                'exercise_type' => $exercises_types[$types[$exercises_id]]
                            ]);
                        }

                        if ($day == "five") {

                            DayFive::create([
                                'exercise_id' => $exercises_id,
                                'workout_id' =>  $workout->id,
                                'exercise_type' => $exercises_types[$types[$exercises_id]]
                            ]);
                        }

                        if ($day == "six") {

                            DaySix::create([
                                'exercise_id' => $exercises_id,
                                'workout_id' =>  $workout->id,
                                'exercise_type' => $exercises_types[$types[$exercises_id]]
                            ]);
                        }

                        if ($day == "seven") {

                            DaySeven::create([
                                'exercise_id' => $exercises_id,
                                'workout_id' =>  $workout->id,
                                'exercise_type' => $exercises_types[$types[$exercises_id]]
                            ]);
                        }

                        DayExerciseBodyPart::create([
                            'day' => $days[$day],
                            'body_part_id' => $body_part_id,
                            'workout_id' =>  $workout->id
                        ]);

                        DayExerciseType::create([
                            'day' => $days[$day],
                            'type' => $exercises_types[$types[$exercises_id]],
                            'workout_id' =>  $workout->id
                        ]);
                    }
                }
            }
        }
    }
}
