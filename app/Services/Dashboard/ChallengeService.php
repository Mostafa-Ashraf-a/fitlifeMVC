<?php


namespace App\Services\Dashboard;


use App\Models\Challenge;
use App\Models\Equipment;
use App\Traits\Photoable;
use Illuminate\Support\Facades\Storage;

class ChallengeService
{
    use Photoable;

    /**
     * @param $request
     */
    public function store($request) : void
    {
        $challenge = $this->storeChallenge($request);
        if ($request->hasFile('image'))
        {
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$challenge->id, 'challenges/images/');
            $challenge->update([
                'image' => $fileName
            ]);
        }
        $challenge->exercises()->attach($request->exercise_id);
    }

    /**
     * @param $request
     * @return mixed
     */
    private function storeChallenge($request) : mixed
    {
        return Challenge::create([
            'en' => [
                'title'       => $request->title_en,
                'description' => $request->description_en,
            ],
            'ar' => [
                'title'       => $request->title_ar,
                'description' => $request->description_ar,
            ],
        ]);
    }

    /**
     * @param $request
     * @param $challenge
     */
    public function update($request, $challenge) : void
    {
        $this->updateChallenge($challenge, $request);

        if($request->hasFile('image') &&
            ($challenge->image != null && Storage::disk('public')->exists('files/challenges/images/'.$challenge->id)))
        {
            $this->deleteFile($challenge->image,$challenge->id, 'challenges/images/');
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$challenge->id, 'challenges/images/');
            $challenge->update([
                'image' => $fileName
            ]);
        }
        if($request->hasFile('image') &&
            ($challenge->image == null))
        {
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$challenge->id, 'challenges/images/');
            $challenge->update([
                'image' => $fileName
            ]);
        }
    }
    /**
     * @param $challenge
     * @param $request
     */
    public function updateChallenge($challenge, $request): void
    {
        $challenge->update([
            'en' => [
                'title'       => $request->title_en,
                'description' => $request->description_en,
            ],
            'ar' => [
                'title'       => $request->title_ar,
                'description' => $request->description_ar,
            ],
        ]);
        $challenge->exercises()->sync($request->exercise_id);
    }
}
