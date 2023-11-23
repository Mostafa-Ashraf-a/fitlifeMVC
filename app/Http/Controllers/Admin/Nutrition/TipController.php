<?php

namespace App\Http\Controllers\Admin\Nutrition;

use App\Http\Controllers\Controller;
use App\Models\Tip;
use App\Models\TipTranslation;
use Illuminate\Http\Request;

class TipController extends Controller
{

    public function index()
    {
        $tips = Tip::orderBy('id', 'DESC')->get();
        return view('admin.tips.index',compact('tips'));
    }


    public function create()
    {
        return view('admin.tips.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            'content_en' => 'required',
            'content_ar' => 'required',
        ]);
        Tip::create([
            'en' => ['title' => $request->title_en, 'content' => $request->content_en],
            'ar' => ['title' => $request->title_ar , 'content' => $request->content_ar],
        ]);
        $notification = array('message' => "Tip of the day Added Successfully!",'alert-type' => 'success');
        return redirect()->to('/manager/tips/')->with($notification);
    }

    public function edit($id)
    {
        $tipEn = TipTranslation::where('tip_id',$id)->where('locale','=','en')->select('title as title_en', 'content as content_en')->first();
        $tipAr = TipTranslation::where('tip_id',$id)->where('locale','=','ar')->select('title as title_ar','content as content_ar')->first();
        return view('admin.tips.edit',compact('tipEn','id','tipAr'));
    }

    public function update(Request $request, Tip $tip)
    {
        $request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            'content_en' => 'required',
            'content_ar' => 'required',
        ]);
        $tip->update([
            'en' => ['title' => $request->title_en, 'content' => $request->content_en],
            'ar' => ['title' => $request->title_ar , 'content' => $request->content_ar],
        ]);
        $notification = array('message' => "Tip of the day Updated Successfully!",'alert-type' => 'success');
        return redirect()->to('/manager/tips/')->with($notification);
    }


    public function destroy($id)
    {
        $tip = Tip::findOrFail($id);
        $tip->delete();
        return response()->json(['message' => "Tip Has been Deleted Successfully!"],200);
    }
}
