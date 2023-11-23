<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExerciseRequest;
use App\Models\BodyPart;
use App\Models\DayFive;
use App\Models\DayFour;
use App\Models\DayOne;
use App\Models\DaySeven;
use App\Models\DaySix;
use App\Models\DayThree;
use App\Models\DayTwo;
use App\Models\Equipment;
use App\Models\Exercise;
use App\Models\ExerciseBodyPart;
use App\Models\ExerciseTranslation;
use App\Models\ExerciseType;
use App\Models\Level;
use App\Services\Dashboard\ExerciseService;
use App\Traits\General;
use App\Traits\Photoable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ExerciseController extends Controller
{
    use Photoable;
    public function index()
    {
        return view('admin.Exercise.index');
    }

    public function dataTable()
    {
        return datatables(
            Exercise::query()
                ->with('level', 'equipment', 'muscle')
                ->orderBy('id', 'DESC')
                )



            ->editColumn('action', function ($row) {
                $button  = '<div class="row">';
                $button .= '<div class="col-md-12 col-sm-6">';
                $button .= '<a class="btn btn-sm btn-info" style="margin-right: 5px;margin-bottom: 5px !important;" href="' . url('manager/exercises/' . $row->id . '/edit') . '"><i class="fa fa-edit"></i></a>';
                $button .= '<button class="btn btn-sm btn-danger" style="margin-right: 5px;margin-bottom: 5px !important;" value="' . $row->id . '" id="delete-model" ><i class="fa fa-trash"></i></button>';
                $button .= '</div></div>';
                return $button;
            })
            ->editColumn('image', function ($row) {
                if ($row->image != null) {
                    $url = Storage::url("files/exercise/images/" . $row->id . "/thumb-" . $row->image);
                    return '<img src="' . $url . '" style="width: 50px; height: 50px; padding: 2px;">';
                }
            })
            ->editColumn('place', function ($row) {
                if ($row->place == 1) {
                    return "Gym";
                } else {
                    return "Home";
                }
            })
            ->editColumn('equipment', function ($row) {
                if ($row->equipment_id != null) {
                    return $row->equipment->title;
                }
            })
            ->editColumn('level', function ($row) {
                if ($row->level_id != null) {
                    return $row->level->title;
                }
            })
            ->editColumn('muscle', function ($row) {
                if ($row->muscle_id != null) {
                    return $row->muscle->title;
                }
            })
            ->editColumn('exercise_category', function ($row) {
                if ($row->exercise_category == 1) {
                    return '<span class="badge badge-pill bg-success" style="width: 6rem; padding: 8px 0;">Pre</span>';
                } elseif ($row->exercise_category == 2) {
                    return '<span class="badge badge-pill bg-warning" style="width: 6rem; padding: 8px 0;">Main</span>';
                } elseif ($row->exercise_category == 3) {
                    return '<span class="badge badge-pill bg-info" style="width: 6rem; padding: 8px 0;">Post</span>';
                } else {
                    return '<span class="badge badge-pill bg-primary" style="width: 6rem; padding: 8px 0;">Cardio</span>';
                }
            })
            ->rawColumns(['image', 'place', 'equipment', 'level', 'muscle', 'exercise_category', 'action'])
            ->toJson();
    }

    public function create()
    {
        $levels = Level::get();
        $equipments = Equipment::get();
        $bodyParts = BodyPart::get();
        $exerciseTypes = ExerciseType::get();
        return view('admin.Exercise.add', compact('levels', 'equipments', 'bodyParts', 'exerciseTypes'));
    }

    public function store(ExerciseRequest $request)
    {
        $exerciseService = new ExerciseService();
        $exerciseService->store($request);
        $notification = array('message' => "Exercise Added Successfully!", 'alert-type' => 'success');
        return redirect()->to('/manager/exercises')->with($notification);
    }

    public function edit($id)
    {
        $levels = Level::get();
        $equipments = Equipment::get();
        $exercise = Exercise::with('muscle')->findOrFail($id);
        $bodyParts = BodyPart::get();
        $exerciseTypes = ExerciseType::get();
        $exerciseAr = ExerciseTranslation::where('exercise_id', $id)->where('locale', 'ar')->select('title', 'tips', 'instructions')->first();
        $exerciseEn = ExerciseTranslation::where('exercise_id', $id)->where('locale', 'en')->select('title', 'tips', 'instructions')->first();
        return view('admin.Exercise.edit', compact('id', 'exerciseAr', 'exerciseEn', 'levels', 'equipments', 'exercise', 'bodyParts', 'exerciseTypes'));
    }

    public function update(ExerciseRequest $request, Exercise $exercise)
    {
        $exerciseService = new ExerciseService();
        $exerciseService->update($request, $exercise);
        $notification = array('message' => "Exercise Updated Successfully!", 'alert-type' => 'info');
        return redirect()->to('/manager/exercises')->with($notification);
    }

    public function destroy($id)
    {
        $exercise = Exercise::findOrFail($id);
        $dayOne = DayOne::where('exercise_id', $id)->first();
        $dayTwo = DayTwo::where('exercise_id', $id)->first();
        $dayThree = DayThree::where('exercise_id', $id)->first();
        $dayFour = DayFour::where('exercise_id', $id)->first();
        $dayFive = DayFive::where('exercise_id', $id)->first();
        $daySix = DaySix::where('exercise_id', $id)->first();
        $daySeven = DaySeven::where('exercise_id', $id)->first();
        $challenge = DB::table('challenge_exercise')->where('exercise_id', $id)->first();
        if ($dayOne || $dayTwo || $dayThree || $dayFour || $dayFive || $daySix || $daySeven || $challenge) {
            return response()->json(['message' => "You can`t delete the Exercise, it has a workout or challenge"], 400);
        } else {
            if ($exercise->image != null) {
                $this->deleteFile($exercise->image, $exercise->id, 'exercise/images/');
            }
            if ($exercise->video != null) {
                $this->deleteFile($exercise->video, $exercise->id, 'exercise/videos/');
            }
            $exercise->delete();
            return response()->json(['message' => "Exercise Deleted Successfully!"], 200);
        }
    }
}
