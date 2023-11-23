<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BodyPart;
use App\Models\Equipment;
use App\Models\Exercise;
use App\Models\FoodExchange;
use App\Models\Goal;
use App\Models\Level;
use App\Models\Manager;
use App\Models\MeasurementUnit;
use App\Models\Post;
use App\Models\Recipe;
use App\Models\Tip;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(){
        $exercise = Exercise::count();
        $workout = Workout::count();
        $bodyPart = BodyPart::count();
        $equipment = Equipment::count();
        $levels = Level::count();
        $goals = Goal::count();
        $recipes = Recipe::count();
        $posts = Post::count();
        $foodExchanges = FoodExchange::count();
        $customers = User::count();
        $measurementUnits = MeasurementUnit::count();
        $tips = Tip::count();

        return view('admin.index',compact('exercise','workout',
            'bodyPart',
            'equipment',
            'goals',
            'recipes',
            'posts',
            'levels',
            'foodExchanges',
            'customers',
            'measurementUnits',
            'tips',
        ));
    }

    public function check(Request $request)
    {
        $request->validate([
           'email' => 'required|exists:managers,email',
            'password' => 'required',
        ]);
        if (!Auth::guard('manager')->attempt($request->only(['email','password']))){
            return redirect()->to('manager/login')->with('fail','The email or password is incorrect');
        }
        return redirect()->to('manager/dashboard');
    }

    public function logout()
    {
        Auth::guard('manager')->logout();
        return redirect()->route('manager.login');
    }

    public function uploadFile(Request $request)
    {
        if($request->hasFile('image'))
        {
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $folder = uniqid() . '-' . now()->timestamp;
            $file->move(public_path('/uploads/' . $folder),$fileName);
            return $folder;
        }
        return '';
    }

    public function viewProfile()
    {
//        dd(Auth::guard('manager')->user()->username);
        return view('admin.profile.view');
    }
    public function updateProfile(Request $request)
    {
        $request->validate([
            'username'         => 'required',
            'email'            => 'required|email',
            'mobile'           => 'required|starts_with:5|digits:9',
        ]);
        Manager::whereId(Auth::guard('manager')->user()->id)->update([
            'username' => $request->username,
            'email' => $request->email,
            'mobile' => $request->mobile,
        ]);
        return back()->with("status", "Information Updated successfully!");
    }
    public function viewChangePassword()
    {
        return view('admin.profile.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password'     => 'required|confirmed',
        ]);
        if ((Hash::check($request->old_password, Auth::guard('manager')->user()->password)) == false) {
            return back()->with("error", "Old Password Doesn't match!");
        } else {
            Manager::whereId(Auth::guard('manager')->user()->id)->update([
                'password' => Hash::make($request->new_password)
            ]);
            return back()->with("status", "Password changed successfully!");
        }
    }
}
