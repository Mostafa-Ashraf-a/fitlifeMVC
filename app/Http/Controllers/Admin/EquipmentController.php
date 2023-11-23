<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EquipmentRequest;
use App\Models\Equipment;
use App\Models\Exercise;
use App\Models\EquipmentTranslation;
use App\Services\Dashboard\EquipmentService;
use App\Traits\Photoable;

class EquipmentController extends Controller
{
    use Photoable;
    public function index()
    {
        $equipments = Equipment::orderBy('id','DESC')->get();
        return view('admin.Equipments.index',compact('equipments'));
    }

    public function create()
    {
        return view('admin.Equipments.add');
    }

    public function store(EquipmentRequest $request)
    {
        $service = new EquipmentService();
        $service->store($request);
        $notification = array('message' => "Equipment Added Successfully!",'alert-type' => 'success');
        return redirect()->to('/manager/equipments')->with($notification);
    }

    public function edit($id)
    {
        $equipment = Equipment::find($id);
        $equipmentEn = EquipmentTranslation::where('equipment_id',$id)->where('locale','=','en')->select('title')->first();
        $equipmentAr = EquipmentTranslation::where('equipment_id',$id)->where('locale','=','ar')->select('title')->first();

        return view('admin.Equipments.edit',compact('equipment','equipmentAr','equipmentEn'));
    }
    public function update(EquipmentRequest $request, Equipment $equipment)
    {
        $service = new EquipmentService();
        $service->update($request, $equipment);
        $notification = array('message' => "Equipment Updated Successfully!",'alert-type' => 'info');
        return redirect()->to('/manager/equipments')->with($notification);
    }
    public function destroy($id)
    {
        $equipment = Equipment::findOrFail($id);
        $exercise = Exercise::where('equipment_id',$id)->first();
        if($exercise)
        {
            return response()->json(['message' => "You can`t delete the Equipment, it has an exercise"],400);
        }else{
            if($equipment->image != null){
                $this->deleteFile($equipment->image,$equipment->id, 'equipments/images/');
            }
            $equipment->delete();
            return response()->json(['message' => "Equipment Deleted Successfully!"],200);
        }
    }
}
