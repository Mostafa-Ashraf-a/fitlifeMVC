<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Goal;
use App\Models\GoalTranslation;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    public function index()
    {
        $goals = Goal::all();
        return view('admin.ExerciseModule.Goals.index',compact('goals'));
    }

    public function edit(Goal $goal)
    {
        $goalEn = GoalTranslation::where('goal_id',$goal->id)->where('locale','=','en')->select('title')->first();
        $goalAr = GoalTranslation::where('goal_id',$goal->id)->where('locale','=','ar')->select('title')->first();
        return view('admin.ExerciseModule.Goals.edit',compact('goal','goalAr','goalEn'));
    }

    public function update(Request $request, Goal $goal)
    {

        $goal->update([
            'en' => ['title'  => $request->title_en],
            'ar' => ['title'  => $request->title_ar],
        ]);
        $notification = array('message' => "Goal Updated Successfully!",'alert-type' => 'info');
        return redirect()->to('/manager/exercise/goals')->with($notification);
    }
}
