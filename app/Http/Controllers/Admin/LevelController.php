<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\LevelTranslation;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index()
    {
        $levels = Level::all();
        return view('admin.ExerciseModule.Levels.index',compact('levels'));
    }
    public function edit(Level $level)
    {
        $levelEn = LevelTranslation::where('level_id',$level->id)->where('locale','=','en')->select('title')->first();
        $levelAr = LevelTranslation::where('level_id',$level->id)->where('locale','=','ar')->select('title')->first();
        return view('admin.ExerciseModule.Levels.edit',compact('level','levelAr','levelEn'));
    }

    public function update(Request $request, Level $level)
    {

        $level->update([
            'en' => ['title'  => $request->title_en],
            'ar' => ['title'  => $request->title_ar],
        ]);
        $notification = array('message' => "Level Updated Successfully!",'alert-type' => 'info');
        return redirect()->to('/manager/exercise/levels')->with($notification);
    }
}
