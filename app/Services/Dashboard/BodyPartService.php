<?php


namespace App\Services\Dashboard;
use App\Models\BodyPart;
use App\Traits\Photoable;
use Illuminate\Support\Facades\Storage;

class BodyPartService
{
    use Photoable;

    /**
     * @param $request
     */
    public function store($request) : void
    {
        $bodyPart = $this->storeBodyPart($request);
        if ($request->hasFile('image'))
        {
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$bodyPart->id, 'bodyParts/images/');
            $bodyPart->update([
                'image' => $fileName
            ]);
        }
    }

    /**
     * @param $request
     * @return mixed
     */
    private function storeBodyPart($request) : mixed
    {
        return BodyPart::create([
            'en' => [
                'title' => $request->title_en,
            ],
            'ar' => [
                'title' => $request->title_ar,
            ],
        ]);
    }

    /**
     * @param $request
     * @param $bodyPart
     */
    public function update($request, $bodyPart) : void
    {
        $this->updateBodyPart($bodyPart, $request);

        if($request->hasFile('image') &&
            ($bodyPart->image != null && Storage::disk('public')->exists('files/bodyParts/images/'.$bodyPart->id)))
        {
            $this->deleteFile($bodyPart->image,$bodyPart->id, 'bodyParts/images/');
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$bodyPart->id, 'bodyParts/images/');
            $bodyPart->update([
                'image' => $fileName
            ]);
        }
        if($request->hasFile('image') &&
            ($bodyPart->image == null))
        {
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$bodyPart->id, 'bodyParts/images/');
            $bodyPart->update([
                'image' => $fileName
            ]);
        }
    }
    /**
     * @param $bodyPart
     * @param $request
     */
    public function updateBodyPart($bodyPart, $request): void
    {
        $bodyPart->update([
            'en' => [
                'title' => $request->title_en,
            ],
            'ar' => [
                'title' => $request->title_ar,
            ],
        ]);
    }
}
