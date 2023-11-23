<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkoutType;
use Illuminate\Http\Request;

class ProgramTypeController extends Controller
{
    public function index()
    {
        $types = WorkoutType::all();
        return view('admin.ProgramTypes.index', compact('types'));
    }
    public function show($id)
    {
        $type = WorkoutType::findOrFail($id);
        return view('admin.ProgramTypes.edit', compact('type'));
    }
    public function update(Request $request, $id)
    {
        $type = WorkoutType::findOrFail($id);
        $type->update([
           'repetition' => $request->repetition
        ]);
        $notification = array('message' => "Repetition Updated Successfully!",'alert-type' => 'info');
        return redirect()->to('/manager/program-types')->with($notification);
    }
}
