<?php

namespace App\Services\Dashboard;

use App\Models\Exercise;
use App\Models\ExerciseBodyPart;
use App\Traits\Photoable;
use Illuminate\Support\Facades\Storage;

class ExerciseService
{
    use Photoable;

    /**
     * @param $request
     */
    public function store($request) : void
    {
        $exercise = $this->storeExercise($request);
        if ($request->hasFile('image'))
        {
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$exercise->id, 'exercise/images/');
            $exercise->update([
                'image' => $fileName
            ]);
        }
        if($request->hasFile('video'))
        {
            $file = $request->file('video');
            $fileName = $this->uploadFile($file, $exercise->id, 'exercise/videos/');
            $exercise->update([
                'video' => $fileName
            ]);
        }
    }
    /**
     * @param $request
     * @param $name
     * @return mixed
     */
    public function storeExercise($request)
    {
       return Exercise::create([
            'en' => [
                'title' => $request->title_en,
                'instructions' => $request->instruction_en,
                'tips' => $request->tip_en,
            ],
            'ar' => [
                'title' => $request->title_ar,
                'instructions' => $request->instruction_ar,
                'tips' => $request->tip_ar,
            ],
            'equipment_id'      => $request->equipment_id,
            'level_id'          => $request->level_id,
            'muscle_id'         => $request->exercise_category == 4 ? 16 : $request->body_part_id,
            'video'             => null,
            'place'             => $request->place,
            'exercise_category' => $request->exercise_category,
        ]);
    }
    /**
     * @param $request
     * @param $exercise
     */
    public function update($request, $exercise) : void
    {
        $this->updateExercise($exercise, $request);
        if($request->hasFile('image') &&
            ($exercise->image != null && Storage::disk('public')->exists('files/exercise/images/'.$exercise->id)))
        {
            $this->deleteFile($exercise->image,$exercise->id, 'exercise/images/');
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$exercise->id, 'exercise/images/');
            $exercise->update([
                'image' => $fileName
            ]);
        }

        if($request->hasFile('image') && ($exercise->image == null))
        {
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$exercise->id, 'exercise/images/');
            $exercise->update([
                'image' => $fileName
            ]);
        }

        if($request->hasFile('video') &&
            ($exercise->video != null && Storage::disk('public')->exists('files/exercise/videos/'.$exercise->id)))
        {
            $this->deleteFile($exercise->video,$exercise->id, 'exercise/videos/');
            $file = $request->file('video');
            $fileName = $this->uploadFile($file, $exercise->id, 'exercise/videos/');
            $exercise->update([
                'video' => $fileName
            ]);
        }
        if($request->hasFile('video') && ($exercise->video == null))
        {
            $file = $request->file('video');
            $fileName = $this->uploadFile($file, $exercise->id, 'exercise/videos/');
            $exercise->update([
                'video' => $fileName
            ]);
        }
    }
    /**
     * @param $exercise
     * @param $request
     */
    public function updateExercise($exercise, $request): void
    {
        $exercise->update([
            'en' => [
                'title'         => $request->title_en,
                'instructions'  => $request->instruction_en,
                'tips'          => $request->tip_en,
            ],
            'ar' => [
                'title'         => $request->title_ar,
                'instructions'  => $request->instruction_ar,
                'tips'          => $request->tip_ar,
            ],
            'equipment_id'      => $request->equipment_id,
            'level_id'          => $request->level_id,
            'muscle_id'         => $request->exercise_category == 4 ? 16 : $request->body_part_id,
            'place'             => $request->place,
            'exercise_category' => $request->exercise_category,
        ]);
    }
}
