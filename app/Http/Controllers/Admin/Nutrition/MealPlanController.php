<?php

namespace App\Http\Controllers\Admin\Nutrition;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Nutrition\MealPlan\StoreRequest;
use App\Http\Requests\Dashboard\Nutrition\MealPlan\UpdateRequest;
use App\Models\Goal;
use App\Models\Meal;
use App\Models\MealPlan;
use App\Models\MealType;
use App\Models\PlanMealTypesMeals;
use App\Services\Dashboard\Nutrition\MealPlanService;
use Illuminate\Support\Facades\DB;

class MealPlanController extends Controller
{
    private $service;

    public function __construct(MealPlanService $service)
    {
        $this->service = $service;
    }
    public function index()
    {
        $mealPlans = MealPlan::query()
            ->with('goal')
            ->latest()
            ->get();
        return view('admin.Nutrition.MealPlans.index',compact('mealPlans'));
    }

    public function create()
    {
        $goals = Goal::get();
        $mealTypes = MealType::get();
        $mealTypesOutput = '';

        $mealTypesOutput .= '<option selected disabled>Select Meal Type</option>';
        foreach($mealTypes as $mealType)
        {
            $mealTypesOutput .= '<option value="'.$mealType["id"].'">'.str_replace("'",'',$mealType->title).'</option>';
        }
        return view('admin.Nutrition.MealPlans.add',compact('goals','mealTypes','mealTypesOutput'));
    }
    public function store(StoreRequest $request)
    {
        $this->service->store($request);
        $notification = array('message' => "Suggested Meal Plan Added Successfully!",'alert-type' => 'success');
        return redirect()->to('/manager/nutrition/meal-plans')->with($notification);
    }
    public function edit($id)
    {
        $mealPlan = MealPlan::query()
            ->with('goal')
            ->findOrFail($id);
        $goals = Goal::get();
        $mealTypes = MealType::get();
        $meals = Meal::where('is_default',1)->get();
        $planMealTypesMeals = PlanMealTypesMeals::where('meal_plan_id', $id)->get();
        $mealTypesOutput = '';
        $mealTypesOutput .= '<option selected disabled>Select Meal Type</option>';

        foreach($mealTypes as $mealType)
        {
            $mealTypesOutput .= '<option value="'.$mealType["id"].'">'.str_replace("'",'',$mealType->title).'</option>';
        }

        return view('admin.Nutrition.MealPlans.edit', compact('mealPlan','goals','mealTypes','meals','mealTypesOutput','planMealTypesMeals'));
    }

    public function update(UpdateRequest $request,MealPlan $mealPlan)
    {
        if($mealPlan->added_by != 2){
            $this->service->update($request, $mealPlan);
        }
        $mealPlan->update([
           'title'  => $request->title
        ]);
        $notification = array('message' => "Suggested Meal Plan Updated Successfully!",'alert-type' => 'success');
        return redirect()->to('/manager/nutrition/meal-plans')->with($notification);
    }

    public function deleteMealTypeMeal($mealTypeId, $mealId, $mealPlanId)
    {
        PlanMealTypesMeals::query()
            ->where('meal_plan_id',$mealPlanId)
            ->where('meal_type_id',$mealTypeId)
            ->where('meal_id',$mealId)
            ->delete();
        return response()->json(['message' => "It's Deleted Successfully!"],200);
    }

    public function destroy($id)
    {
        $mealPlan = MealPlan::findOrFail($id);
        $userMealPlan = DB::table('user_meals_plans')->where('plan_id', $id)->first();
        $userSuggestedMealPlan = DB::table('user_suggested_plan')->where('plan_id', $id)->first();
        if($userMealPlan || $userSuggestedMealPlan)
        {
            return response()->json(['message' => "You can`t delete the Meal Type, it has a custom or suggested plan"],400);
        }
        $mealPlan->delete();
        return response()->json(['message' => "Meal Plan Has been Deleted Successfully!"],200);
    }
}
