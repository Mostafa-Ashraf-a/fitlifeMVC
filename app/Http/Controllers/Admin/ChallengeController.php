<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChallengeRequest;
use App\Models\Challenge;
use App\Models\ChallengeTranslation;
use App\Models\Exercise;
use App\Services\Dashboard\ChallengeService;
use App\Traits\General;
use App\Traits\Photoable;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    use Photoable;
    public function index()
    {
        $challenges = Challenge::with('exercises')->orderBy('id','DESC')->get();
        return view('admin.Challenges.index',compact('challenges'));
    }

    public function create()
    {
        $exercises = Exercise::withTranslation()->get();
        return view('admin.Challenges.add',compact('exercises'));
    }

    public function store(ChallengeRequest $request)
    {
        $service = new ChallengeService();
        $service->store($request);
        $notification = array('message' => "Challenge Created Successfully!",'alert-type' => 'success');
        return redirect()->to('/manager/challenges')->with($notification);
    }
    public function show($id)
    {
        $challenge =   Challenge::with('exercises')->withTranslation()->findOrFail($id);
        $challengeEn = ChallengeTranslation::where('locale','=','en')->where('challenge_id',$id)->first();
        $challengeAr = ChallengeTranslation::where('locale','=','ar')->where('challenge_id',$id)->first();
        $exercises = Exercise::withTranslation()->get();
        return view('admin.Challenges.edit',compact('challenge','challengeAr','challengeEn','exercises'));
    }
    public function update(ChallengeRequest $request,Challenge $challenge)
    {
        $service = new ChallengeService();
        $service->update($request, $challenge);
        $notification = array('message' => "Challenge Updated Successfully!",'alert-type' => 'info');
        return redirect()->to('/manager/challenges')->with($notification);
    }

    public function destroy($id)
    {
        $challenge = Challenge::findOrFail($id);
        if($challenge->image != null)
        {
            $this->deleteFile($challenge->image,$challenge->id, 'challenges/images/');
        }
        $challenge->exercises()->detach();
        $challenge->delete();
        return response()->json(['message' => "Challenge Deleted Successfully!"],200);
    }
}
