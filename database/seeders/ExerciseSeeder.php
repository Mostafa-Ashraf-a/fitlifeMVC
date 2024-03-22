<?php

namespace Database\Seeders;

use App\Models\BodyPart;
use App\Models\Exercise;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('exercises')->truncate();
        DB::table('exercise_translations')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $bodyPart = BodyPart::get();
        $places = ["GYM" => 1, "Home" => 2];

        $muscles = [
            "Shoulders" =>  1,
            "Chest" =>  2,
            "Quads" =>  3,
            "Biceps" =>  4,
            "Abs" =>  5,
            "Obliques" =>  6,
            "Forearms" =>  7,
            "Adductors" =>  8,
            "Traps" =>  9,
            "Triceps" =>  10,
            "Hamstrings" =>  11,
            "Calves" =>  12,
            "Back" =>  13,
            "Glutes" =>  14,
            "Abductors" =>  15,
            "Cardio" =>  16,
        ];

        $equipments = [
            "Dumbbells" => 1,
            "Barbell" => 2,
            "Barbell and Bench" => 3,
            "Dumbbells and Bench" => 4,
            "Barbell and Preacher" => 5,
            "Dumbbells and Preacher" => 6,
            "Machine" => 7,
            "Plate" => 8,
            "Cable and Bench" => 9,
            "Cable" => 10,
            "Bench" => 11,
            "Bodyweight" => 12,
            "Ball" => 13,
            "Kettlebells" => 14,
            "Plate & Bench" => 15,
            "Physio Ball" => 16,
            "Wheel Roll" => 17,
            "Resistance Band" => 18,
        ];

        $levels = [
            "Beginners" => 1,
            "Intermediates" => 2,
            "Advanced" => 3,
        ];

        $types = [
            "Pre" => 1,
            "Main" => 2,
            "Post" => 3,
            "Cardio" => 4,
        ];

        $descriptions = config('exercises.descriptions');
        $names = config('exercises.names');
        $equipments_config = config('exercises.equipments');
        $muscles_config = config('exercises.muscles');
        $places_config = config('exercises.places');

        foreach ($names as $id => $name) {

            // if (!in_array($id, [117, 92, 88])) {

            $exercise_model = Exercise::create(
                [
                    'id'                  => $id,
                    'equipment_id'        => $equipments[$equipments_config[$id]], #
                    'level_id'            => 1, #
                    'exercise_category'   => 2,
                    'muscle_id'           => $muscles[$muscles_config[$id]], #
                    'place'               => $places[$places_config[$id]],
                    'ar' => [
                        'title'           => $name,
                        'tips'            => " ",
                        "instructions"    => $descriptions[$id]['ar'],
                    ],
                    'en' => [
                        'title'           => $name,
                        'tips'            => " ",
                        "instructions"    => $descriptions[$id]['en'],
                    ],
                ],
            );

            // New Request Instance
            $request = new Request();

            //Images
            $image_name = "images/$id.png";
            $image_file = public_path($image_name);

            if (!file_exists($image_file)) {
                $image_name = "images/$id.PNG";
                $image_file = public_path($image_name);
            }

            //Videos
            $video_name = "videos/$id.mp4";
            $video_file = public_path($video_name);

            if (file_exists($video_file) || file_exists($image_file)) {
                $video_uploaded = new UploadedFile($video_file, $video_name);
                $image_uploaded = new UploadedFile($image_file, $image_name);
                $request->files->set('image', $image_uploaded);
                $request->files->set('video', $video_uploaded);
                $image = $request->file('image');
                $video = $request->file('video');
            }

            if (file_exists($image_file)) {

                $extension_image = $image->getClientOriginalExtension();
                $fileNameImage = uniqid() . '-' . time() . '.' . $extension_image;
                $image_path = 'exercise/images/';
                $image->storeAs('files/' . $image_path . $id . '/', $fileNameImage, 'public');
                Image::make(storage_path('app/public/files/' . $image_path . $id . '/' . $fileNameImage))
                    ->save(storage_path('app/public/files/' . $image_path . $id . '/thumb-' . $fileNameImage));

                $exercise_model->update([
                    'image' => $fileNameImage,
                ]);
            }

            if (file_exists($video_file)) {

                $extension_video = $video->getClientOriginalExtension();
                $fileNameVideo = uniqid() . '-' . time() . '.' . $extension_video;
                $video_path = 'exercise/videos/';
                $video->storeAs('files/' . $video_path . $id . '/', $fileNameVideo, 'public');

                $exercise_model->update([
                    'video' => $fileNameVideo
                ]);
            }
        }
        // }
    }
}
