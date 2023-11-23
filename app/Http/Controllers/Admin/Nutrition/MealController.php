<?php

namespace App\Http\Controllers\Admin\Nutrition;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Nutrition\MealRequest;
use App\Models\Meal;
use App\Models\MealRecipe;
use App\Models\MealTranslation;
use App\Models\MealType;
use App\Models\Recipe;
use App\Services\Dashboard\Nutrition\MealService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MealController extends Controller
{
    private $service;

    public function __construct(MealService $service)
    {
        $this->service = $service;
    }
    public function index()
    {
        $meals = Meal::query()
            ->with('mealType')
            ->latest()
            ->get();
        return view('admin.Nutrition.Meals.index',compact('meals'));
    }
    public function create()
    {
        $mealTypes = MealType::get();
        $recipes = Recipe::get();
        return view('admin.Nutrition.Meals.add',compact('mealTypes','recipes'));
    }
    public function store(MealRequest $request)
    {
        $this->service->store($request);
        $notification = array('message' => "Meal Added Successfully!",'alert-type' => 'success');
        return redirect()->to('/manager/nutrition/meals')->with($notification);
    }
    public function edit(Meal $meal)
    {
        $recipes = Recipe::get();
        $mealRecipes = MealRecipe::where('meal_id', $meal->id)->get();
        $mealTypes = MealType::get();
        $mealEn = MealTranslation::where('meal_id',$meal->id)->where('locale','=','en')->select('title')->first();
        $mealAr = MealTranslation::where('meal_id',$meal->id)->where('locale','=','ar')->select('title')->first();
        return view('admin.Nutrition.Meals.edit',compact('recipes','mealRecipes','mealTypes','meal','mealAr','mealEn'));
    }

    public function update(Request $request, Meal $meal)
    {
        if($meal->is_default != 1)
        {
            $request->validate([
                'title_en'         => 'required',
                'title_ar'         => 'required',
            ]);
        }
        else{
            $request->validate([
                'title_en'         => 'required',
                'title_ar'         => 'required',
                'meal_type_id'     => 'required',
                'recipe_id'        => 'required',
            ]);
        }
        $this->service->update($request, $meal);
        $notification = array('message' => "Meal Updated Successfully!",'alert-type' => 'info');
        return redirect()->to('/manager/nutrition/meals')->with($notification);
    }

    public function listMeals($mealTypeId)
    {
        $meals = Meal::where('meal_type_id', $mealTypeId)->get();
        return response()->json(['data'=>$meals],200);
    }
    public function destroy($id)
    {
        $meal = Meal::findOrFail($id);
        $mealRecipes = MealRecipe::where('meal_id', $meal->id)->get();
        $mealPlan = DB::table('user_meals_plans')->where('meal_id', $meal->id)->first();
        if($mealRecipes || $mealPlan)
        {
            return response()->json(['message' => "You can`t delete the Meal, it has a plan"],400);
        }else{
            $meal->delete();
            return response()->json(['message' => "Meal Has Been Deleted Successfully!"],200);
        }
    }
}
