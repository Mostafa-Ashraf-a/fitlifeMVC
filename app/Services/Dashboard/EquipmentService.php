<?php


namespace App\Services\Dashboard;


use App\Models\BodyPart;
use App\Models\Equipment;
use App\Traits\Photoable;
use Illuminate\Support\Facades\Storage;

class EquipmentService
{
    use Photoable;

    /**
     * @param $request
     */
    public function store($request) : void
    {
        $equipment = $this->storeEquipment($request);
        if ($request->hasFile('image'))
        {
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$equipment->id, 'equipments/images/');
            $equipment->update([
                'image' => $fileName
            ]);
        }
    }

    /**
     * @param $request
     * @return mixed
     */
    private function storeEquipment($request) : mixed
    {
        return Equipment::create([
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
     * @param $equipment
     */
    public function update($request, $equipment) : void
    {
        $this->updateEquipment($equipment, $request);

        if($request->hasFile('image') &&
            ($equipment->image != null && Storage::disk('public')->exists('files/equipments/images/'.$equipment->id)))
        {
            $this->deleteFile($equipment->image,$equipment->id, 'equipments/images/');
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$equipment->id, 'equipments/images/');
            $equipment->update([
                'image' => $fileName
            ]);
        }
        if($request->hasFile('image') &&
            ($equipment->image == null))
        {
            $file = $request->file('image');
            $fileName = $this->uploadImage($file,$equipment->id, 'equipments/images/');
            $equipment->update([
                'image' => $fileName
            ]);
        }
    }
    /**
     * @param $equipment
     * @param $request
     */
    public function updateEquipment($equipment, $request): void
    {
        $equipment->update([
            'en' => [
                'title' => $request->title_en,
            ],
            'ar' => [
                'title' => $request->title_ar,
            ],
        ]);
    }
}
