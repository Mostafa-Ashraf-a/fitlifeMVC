<?php

namespace App\Http\Controllers\Admin\Nutrition;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddFoodTypeRequest;
use App\Http\Requests\UpdateFoodTypeRequest;
use App\Models\FoodType;
use App\Models\FoodTypeTranslation;
use App\Services\Dashboard\FoodTypeService;
use App\Traits\General;

class FoodTypeController extends Controller
{

    public function index()
    {
        $foodTypes = FoodType::query()
            ->latest()
            ->get();
        return view('admin.Nutrition.FoodTypes.index',compact('foodTypes'));
    }
    public function edit(FoodType $foodType)
    {
        $foodTypeEn = FoodTypeTranslation::where('food_type_id',$foodType->id)->where('locale','=','en')->select('title')->first();
        $foodTypeAr = FoodTypeTranslation::where('food_type_id',$foodType->id)->where('locale','=','ar')->select('title')->first();
        return view('admin.Nutrition.FoodTypes.edit',compact('foodType','foodTypeAr','foodTypeEn'));
    }
    public function update(AddFoodTypeRequest $request, FoodType $foodType)
    {
        $service = new FoodTypeService();
        $service->update($request, $foodType);
        $notification = array('message' => "Food Type Updated Successfully!",'alert-type' => 'info');
        return redirect()->to('/manager/nutrition/food-types')->with($notification);
    }

}
