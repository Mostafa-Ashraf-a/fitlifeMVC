<?php


namespace App\Services\Dashboard\Nutrition;


use App\Models\MeasurementUnit;

class MeasurementUnitService
{
    public function store($request): void
    {
        MeasurementUnit::create([
            'en' => [
                'name' => $request->name_en,
            ],
            'ar' => [
                'name' => $request->name_ar,
            ],
        ]);
    }
    public function update($request, $measurementUnit): void
    {
        $measurementUnit->update([
            'en' => [
                'name' => $request->name_en,
            ],
            'ar' => [
                'name' => $request->name_ar,
            ],
        ]);
    }
}
