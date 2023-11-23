<?php

namespace App\Http\Controllers\Admin\Nutrition;

use App\Http\Controllers\Controller;
use App\Models\MealType;
use App\Models\MealTypeTranslation;
use App\Services\Dashboard\Nutrition\MealTypeService;
use App\Traits\Photoable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MealTypeController extends Controller
{
    use Photoable;
    private $service;

    public function __construct(MealTypeService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $mealTypes = MealType::query()
            ->orderBy('id', 'DESC')
            ->get();
        return view('admin.Nutrition.MealTypes.index',compact('mealTypes'));
    }

    public function create()
    {
        return view('admin.Nutrition.MealTypes.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            'image'    => 'required',
        ]);
        $this->service->store($request);
        $notification = array('message' => "Meal Type Added Successfully!",'alert-type' => 'success');
        return redirect()->to('/manager/nutrition/meal-types')->with($notification);
    }

    public function edit($id)
    {
        $mealType = MealType::findOrFail($id);
        $mealTypeEn = MealTypeTranslation::where('meal_type_id',$id)->where('locale','=','en')->select('title')->first();
        $mealTypeAr = MealTypeTranslation::where('meal_type_id',$id)->where('locale','=','ar')->select('title')->first();
        return view('admin.Nutrition.MealTypes.edit',compact('mealTypeEn','mealType','mealTypeAr'));
    }

    public function update(Request $request, MealType $mealType)
    {
        $request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            'image'    => 'sometimes',
        ]);
        $this->service->update($request, $mealType);
        $notification = array('message' => "Meal Type Updated Successfully!",'alert-type' => 'success');
        return redirect()->to('/manager/nutrition/meal-types')->with($notification);
    }

    public function destroy($id)
    {
        $mealType = MealType::findOrFail($id);
        $mealRecipe = DB::table('meal_recipes')->where('meal_type_id', $id)->first();
        $planMealType = DB::table('plan_meal_types_meals')->where('meal_type_id', $id)->first();
        $userPlanMealType = DB::table('user_meal_type_food_exchanges')->where('meal_type_id', $id)->first();
        if($mealRecipe || $planMealType || $userPlanMealType)
        {
            return response()->json(['message' => "You can`t delete the Meal Type, it has a custom or suggested plan"],400);
        }
        if($mealType->image != null)
        {
            $this->deleteFile($mealType->image,$mealType->id, 'mealTypes/images/');
        }
        $mealType->delete();
        return response()->json(['message' => "Meal Type Unit Deleted Successfully!"],200);
    }
}
