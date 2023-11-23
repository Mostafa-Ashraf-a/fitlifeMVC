<?php

namespace App\Http\Controllers\Admin\Nutrition;

use App\Http\Controllers\Controller;
use App\Http\Requests\MeasurementUnitRequest;
use App\Models\MeasurementUnit;
use App\Models\MeasurementUnitTranslation;
use App\Services\Dashboard\Nutrition\MeasurementUnitService;
use App\Traits\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MeasurementUnitController extends Controller
{

    private $service;
    public function __construct(MeasurementUnitService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $measurementUnits = MeasurementUnit::query()
            ->orderBy('id', 'DESC')
            ->get();
        return view('admin.Nutrition.MeasurementUnits.index',compact('measurementUnits'));
    }
    public function create()
    {
        return view('admin.Nutrition.MeasurementUnits.add');
    }
    public function store(MeasurementUnitRequest $request)
    {
        $this->service->store($request);
        $notification = array('message' => "Measurement Unit Added Successfully!",'alert-type' => 'success');
        return redirect()->to('/manager/nutrition/measurement-units/')->with($notification);
    }

    public function edit($id)
    {
        $measurementUnitEn = MeasurementUnitTranslation::where('measurement_unit_id',$id)->where('locale','=','en')->select('name as name_en')->first();
        $measurementUnitAr = MeasurementUnitTranslation::where('measurement_unit_id',$id)->where('locale','=','ar')->select('name as name_ar')->first();
        return view('admin.Nutrition.MeasurementUnits.edit',compact('id','measurementUnitEn','measurementUnitAr'));
    }
    public function update(MeasurementUnitRequest $request, MeasurementUnit $measurementUnit)
    {
        $this->service->update($request,$measurementUnit);
        $notification = array('message' => "Measurement Unit Updated Successfully!",'alert-type' => 'info');
        return redirect()->to('/manager/nutrition/measurement-units/')->with($notification);
    }

    public function destroy($id)
    {
        $measurementUnit = MeasurementUnit::findOrFail($id);
        $checkFoodExchange = DB::table('food_exchange_measurements')->where('measurement_unit_id',$id)->first();
        if($checkFoodExchange)
        {
            return response()->json(['message' => "You can`t delete the Measurement Unit, it has a food exchange"],400);
        }
        $measurementUnit->delete();
        return response()->json(['message' => "Measurement Unit Deleted Successfully!"],200);
    }
}
