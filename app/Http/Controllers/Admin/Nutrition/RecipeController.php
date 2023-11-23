<?php

namespace App\Http\Controllers\Admin\Nutrition;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddRecipeRequest;
use App\Models\FoodExchange;
use App\Models\Recipe;
use App\Models\RecipeFoodExchange;
use App\Models\RecipeTranslation;
use App\Services\Dashboard\Nutrition\RecipeService;
use App\Traits\Photoable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    use Photoable;
    private $service;

    public function __construct(RecipeService $service)
    {
        $this->service = $service;
    }
    public function index()
    {
        $recipes = Recipe::query()
            ->latest()
            ->get();
        return view('admin.Nutrition.Recipe.index',compact('recipes'));
    }

    public function create()
    {
        $foodExchanges = FoodExchange::get();
        return view('admin.Nutrition.Recipe.add',compact('foodExchanges'));
    }

    public function store(AddRecipeRequest $request)
    {
        $this->service->store($request);
        $notification = array('message' => "Recipe Added Successfully!",'alert-type' => 'success');
        return redirect()->to('/manager/nutrition/recipes')->with($notification);
    }

    public function edit($id)
    {
        $foodExchanges = FoodExchange::get();
        $recipe = Recipe::findOrFail($id);
        $recipeEn = RecipeTranslation::where('recipe_id',$id)->where('locale','=','en')->select('title','instructions','other_info')->first();
        $recipeAr = RecipeTranslation::where('recipe_id',$id)->where('locale','=','ar')->select('title','instructions','other_info')->first();
        $recipeFoodExchanges = RecipeFoodExchange::where('recipe_id',$id)->get();
        return view('admin.Nutrition.Recipe.edit',compact('recipe','recipeFoodExchanges','foodExchanges','recipeAr','recipeEn'));
    }
    public function update(Request $request, Recipe $recipe)
    {
        $request->validate([
            'title_en'                => 'required',
            'title_ar'                => 'required',
            'instruction_en'          => 'required',
            'instruction_ar'          => 'required',
            'other_info_en'           => 'sometimes',
            'other_info_ar'           => 'sometimes',
            'food_exchange_id'        => 'required',
            'image'                   => 'sometimes|mimes:jpg,png,jpeg|max:5048',
        ]);
        $this->service->update($request, $recipe);
        $notification = array('message' => "Recipe Updated Successfully!",'alert-type' => 'info');
        return redirect()->to('/manager/nutrition/recipes')->with($notification);
    }

    public function destroy($id)
    {
        $recipe = Recipe::findOrFail($id);
        $suggestedPlan = DB::table('user_suggested_plan')->where('recipe_id', $recipe->id)->first();
        if($suggestedPlan)
        {
            return response()->json(['message' => "You can`t delete the Recipe, it has a plan"],400);
        }else{
            if($recipe->image != null)
            {
                $this->deleteFile($recipe->image,$recipe->id, 'recipes/images/');
            }
            $recipe->delete();
            return response()->json(['message' => "Meal Has Been Deleted Successfully!"],200);
        }
    }
}
