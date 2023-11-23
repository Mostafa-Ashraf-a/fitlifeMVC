<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanManagementRequest;
use App\Models\PlanDuration;
use App\Models\PlanManagement;
use App\Models\PlanManagementTranslation;
use Illuminate\Http\Request;

class PlanManagementController extends Controller
{
    public function index()
    {
        $planManagements = PlanManagement::with('planDuration')->withTranslation()->latest()->get();
        return view('admin.PlanManagements.index', compact('planManagements'));
    }

    public function create()
    {
        $planDurations = PlanDuration::withTranslation()->where('status', 1)->get();
        return view('admin.PlanManagements.add', compact('planDurations'));
    }

    public function store(PlanManagementRequest $request)
    {
        PlanManagement::create([
            'en' => [
                'plan_name' => $request->plan_name_en,
                'description' => $request->description_en,
                'features' => $request->features_en,
            ],
            'ar' => [
                'plan_name' => $request->plan_name_ar,
                'description' => $request->description_ar,
                'features' => $request->features_ar,
            ],
            'plan_duration_id' => $request->plan_duration_id,
            'trail_period' => $request->trial_period ?? 0,
            'price' => $request->price,
        ]);
        $notification = array('message' => "Plan Created Successfully!", 'alert-type' => 'success');
        return redirect()->to('/manager/plan-managements')->with($notification);
    }

    public function show($id)
    {
        $plan = PlanManagement::findOrFail($id);
        $planEn = PlanManagementTranslation::where('plan_management_id',$id)->where('locale','=','en')->first();
        $planAr = PlanManagementTranslation::where('plan_management_id',$id)->where('locale','=','ar')->first();
        $planDurations = PlanDuration::withTranslation()->where('status', 1)->get();
        return view('admin.PlanManagements.edit',compact('plan','planEn','planAr','planDurations'));
    }
    public function update(Request $request, PlanManagement $planManagement)
    {
        $planManagement->update([
                'en' => [
                    'plan_name' => $request->plan_name_en,
                    'description' => $request->description_en,
                    'features' => $request->features_en,
                ],
                'ar' => [
                    'plan_name' => $request->plan_name_ar,
                    'description' => $request->description_ar,
                    'features' => $request->features_ar,
                ],
                'trail_period' => $request->trail_period,
                'price' => $request->price,
            ]);
        $notification = array('message' => "Plan Updated Successfully!", 'alert-type' => 'success');
        return redirect()->to('/manager/plan-managements')->with($notification);
    }
    public function changeStatus(Request $request)
    {
        $plan = PlanManagement::findOrFail($request->id);
        if($plan->is_active != 1)
        {
            $plan->update(['is_active'=>1]);
        }else{
            $plan->update(['is_active'=>0]);
        }
        return response()->json(['result'=>1],200);
    }
}
