<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.Users.index',compact('users'));
    }
    public function changeStatus(Request $request)
    {
        $user = User::findOrFail($request->id);

        if($user->status != 1)
        {
            $user->update(['status'=> 1]);
        }else{
            $user->update(['status'=> 0]);
        }
        return response()->json(['result'=>1],200);
    }
    public function create()
    {
        return view('admin.Users.add');
    }
    public function store(Request $request)
    {
        $request->validate([
            'mobile'   => 'required|starts_with:5|digits:9|unique:users',
            'email'    => 'nullable|email|unique:users',
            'password' => 'required',
            'full_name' => 'required',
            'gender'   => 'required'
        ]);
        User::create([
            'full_name'   => $request->full_name,
            'mobile'      => $request->mobile,
            'email'       => $request->email,
            'gender'       => $request->gender,
            'password'     => Hash::make($request->password),
            'is_verified'     => 1,
        ]);
        $notification = array('message' => "Customer Created Successfully!",'alert-type' => 'success');
        return redirect()->to('/manager/users')->with($notification);
    }
}
