<?php


namespace App\Traits;


use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait Photoable
{
    /**
     * @param $file
     * @param int $modelId
     * @param string $path
     * @return string
     */
    public function uploadImage($file, int $modelId, string $path) : string
    {
        $extension = $file->getClientOriginalExtension();
        $fileName = uniqid().'-'.time().'.'.$extension;
        $file->storeAs('files/' . $path . $modelId . '/',$fileName, 'public');
        Image::make(storage_path('app/public/files/'. $path . $modelId . '/' . $fileName))
            ->save(storage_path('app/public/files/' . $path . $modelId . '/thumb-' . $fileName));
        return $fileName;
    }

    /**
     * @param $file
     * @param int $modelId
     * @param string $path
     * @return mixed
     */
    public function uploadFile($file, int $modelId, string $path) : string
    {
        $extension = $file->getClientOriginalExtension();
        $fileName = uniqid().'-'.time().'.'.$extension;
        $file->storeAs('files/' . $path . $modelId . '/',$fileName, 'public');
        return $fileName;
    }

    public function deleteFile($file, int $modelId, string $path)
    {
        Storage::disk('public')->delete('files/' . $path . $modelId . '/'. $file);
        Storage::disk('public')->delete('files/' . $path . $modelId . '/thumb-'. $file);
    }
}
