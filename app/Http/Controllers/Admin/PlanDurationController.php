<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlanDuration;
use Illuminate\Http\Request;

class PlanDurationController extends Controller
{

    public function index()
    {
        $planDurations = PlanDuration::withTranslation()->latest()->get();
        return view('admin.PlanDuration.index',compact('planDurations'));
    }

    public function create()
    {
//        return view('admin.PlanDuration.add');
    }

    public function store(Request $request)
    {
//        $request->validate([
//            'duration_name_en'     => 'required',
//            'duration_name_ar'     => 'required',
//        ]);
//        PlanDuration::create([
//            'en' => [
//                'duration_name'       => $request->duration_name_en,
//            ],
//            'ar' => [
//                'duration_name'       => $request->duration_name_ar,
//            ],
//        ]);
//        $notification = array('message' => "Plan Duration Created Successfully!",'alert-type' => 'success');
//        return redirect()->to('/manager/plan-durations')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(Request $request)
    {
        $plan = PlanDuration::findOrFail($request->id);
        if($plan->status != 1)
        {
            $plan->update(['status'=>1]);
        }else{
            $plan->update(['status'=>2]);
        }
        return response()->json(['result'=>1],200);
    }
}
