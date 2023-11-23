<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddBodyPartRequest;
use App\Models\BodyPart;
use App\Models\BodyPartTranslation;
use App\Services\Dashboard\BodyPartService;


class BodyPartController extends Controller
{
    public function index(){
        $bodyParts = BodyPart::orderBy('id','DESC')->get();
        return view('admin.BodyParts.index',compact('bodyParts'));
    }

    public function edit($id)
    {
        $bodyPart = BodyPart::find($id);
        $bodyPartAr = BodyPartTranslation::where('body_part_id',$id)->where('locale','ar')->select('title')->first();
        $bodyPartEn = BodyPartTranslation::where('body_part_id',$id)->where('locale','en')->select('title')->first();
        return view('admin.BodyParts.edit',compact('bodyPart','bodyPartAr','bodyPartEn'));
    }
    public function update(AddBodyPartRequest $request, BodyPart $bodyPart)
    {
        $service = new BodyPartService();
        $service->update($request, $bodyPart);
        $notification = array('message' => "Body Part Updated Successfully!",'alert-type' => 'info');
        return redirect()->to('/manager/body-parts')->with($notification);
    }
}
