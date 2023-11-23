<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddWorkoutRequest;
use App\Http\Requests\UpdateWorkoutRequest;
use App\Models\BodyPart;
use App\Models\DayExerciseBodyPart;
use App\Models\DayExerciseType;
use App\Models\DayFive;
use App\Models\DayFour;
use App\Models\DayOne;
use App\Models\DaySeven;
use App\Models\DaySix;
use App\Models\DayThree;
use App\Models\DayTwo;
use App\Models\Exercise;
use App\Models\ExerciseType;
use App\Models\Goal;
use App\Models\Level;
use App\Models\Workout;
use App\Models\WorkoutType;
use App\Services\Dashboard\WorkoutService;
use App\Traits\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkoutController extends Controller
{
    use General;
    private $service;
    public function __construct(WorkoutService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $workouts = Workout::with('level','goal')->orderBy('id','DESC')->get();
        return view('admin.Workouts.index',compact('workouts'));
    }

    public function create()
    {
        $levels = Level::get();
        $goals = Goal::get();
        $bodyParts = BodyPart::get();
        $result = ExerciseType::get();
        $output = '';
        $types = WorkoutType::all();
        foreach($result as $row)
        {
            $output .= '<option value="'.$row["type"].'">'.$row["value"].'</option>';
        }
        $bodyPartResult = '';
        foreach ($bodyParts as $bodyPart)
        {
            $bodyPartResult .= '<option value="'.$bodyPart["id"].'">'.$bodyPart["title"].'</option>';
        }
        return view('admin.Workouts.add',compact('types','levels','goals','bodyParts','output','bodyPartResult'));
    }

    public function getExercise(Request $request)
    {
        $exercises = Exercise::query()
            ->where('muscle_id',$request->body_part_id)
            ->where('exercise_category',$request->exercise_type)
            ->get();
        $result = '';
        foreach ($exercises as $exercise){
            $result .= '<option value="'.$exercise["id"].'">'.$exercise["title"].'</option>';
        }
        return $result;
    }

    public function store(AddWorkoutRequest $request)
    {
        $this->service->store($request);
        $notification = array('message' => "Workout Added Successfully!",'alert-type' => 'success');
        return redirect()->to('/manager/workouts')->with($notification);
    }

    public function updateWorkout($request,$name){
        Workout::findOrFail($request->workout_id)->update([
            'title'             => str_replace('','-',$request->title),
            'description'      => $request->description,
            'goal_id'          => $request->goal_id,
            'level_id'              => $request->level_id,
            'duration'              => $request->duration,
            'type_id'           => $request->type_id,
            'place_type'        => $request->place_type,
            'image'             => $name,
        ]);

    }
    public function edit($id)
    {
        $workout = Workout::findOrFail($id);
        $goals = Goal::get();
        $levels = Level::get();
        $bodyParts = BodyPart::get();
        $exercise_types = ExerciseType::get();
        $output = '';
        $typeDays = DayExerciseType::where('workout_id',$id)->get();
        $exerciseBodyParts = DayExerciseBodyPart::where('workout_id',$id)->get();
        $exerciseDays1 = DayOne::join('exercises','exercises.id','=','day_ones.exercise_id')
            ->join('exercise_translations','exercise_translations.exercise_id','=','exercises.id')
            ->where('exercise_translations.locale','=','en')
            ->where('workout_id',$id)
            ->select('exercises.id','exercise_translations.title')
            ->get();
        $types = WorkoutType::all();

        foreach($exercise_types as $row)
        {
            $output .= '<option value="'.$row["type"].'">'.$row["value"].'</option>';
        }
        $bodyPartResult = '';
        foreach ($bodyParts as $bodyPart)
        {
            $bodyPartResult .= '<option value="'.$bodyPart["id"].'">'.$bodyPart["title"].'</option>';
        }

        return view('admin.Workouts.edit',compact('types','workout','goals','levels','bodyParts','typeDays','exerciseBodyParts','exerciseDays1', 'output', 'bodyPartResult', 'exercise_types'));
    }
    public function update(UpdateWorkoutRequest $request)
    {
        $workout = Workout::findOrFail($request->workout_id);

        /**
         * the below is temp and need to be adjusted but I will leave it that way for now
         *
         * @todo delete when needed and update or create the items
         */
        $workout->deleteDays();
        $this->service->store($request);

        if ($request->file('image')){
            $oldImage = $request->old_image;
            if($oldImage){
                unlink(base_path('assets/images/workouts/'.$oldImage));
            }
            $path = 'assets/images/workouts';
            $name = $this->uploadFile($request->image,$request->title,$path);
            $this->updateWorkout($request,$name);
            $notification = array('message' => "Workout Updated Successfully!",'alert-type' => 'info');
            return redirect()->to('/manager/workouts')->with($notification);
        }else{
            $workout->update([
                'title'             => str_replace('','-',$request->title),
                'description'      => $request->description,
                'goal_id'          => $request->goal_id,
                'level_id'              => $request->level_id,
                'duration'              => $request->duration,
                'status'              => $request->status,
                'type_id'           => $request->type_id,
                'place_type'        => $request->place_type,
            ]);
            $notification = array('message' => "Workout Updated Successfully!",'alert-type' => 'info');
            return redirect()->to('/manager/workouts')->with($notification);
        }
    }
//    public function destroy($id)
//    {
//        $workout = Workout::find($id);
//        if($workout->image != null){
//            unlink(base_path('assets/images/workouts/'.$workout->image));
//        }
//        DayOne::where('workout_id',$id)->delete();
//        DayTwo::where('workout_id',$id)->delete();
//        DayThree::where('workout_id',$id)->delete();
//        Dayfour::where('workout_id',$id)->delete();
//        DayFive::where('workout_id',$id)->delete();
//        DaySix::where('workout_id',$id)->delete();
//        DaySeven::where('workout_id',$id)->delete();
//        DayExerciseType::where('workout_id',$id)->delete();
//        DayExerciseBodyPart::where('workout_id',$id)->delete();
//        $workout->delete();
//        $notification = array('message' => "Workout Deleted Successfully!",'alert-type' => 'error');
//        return redirect()->to('/manager/workouts')->with($notification);
//    }

    public function destroy($id)
    {
        $workout = Workout::find($id);
        $program = DB::table('user_exercise_suggestion')->where('workout_id',$id)->first();
        if($program)
        {
            return response()->json(['message' => "You can`t delete the Workout, it has a user program"],400);
        }else{
            $workout->delete();
            return response()->json(['message' => "Workout Deleted Successfully!"],200);
        }
    }


    public function getExerciseTypes()
    {
        $result = ExerciseType::get();
        $output = '';
        foreach($result as $row)
        {
            $output .= '<option value="'.$row["type"].'">'.$row["value"].'</option>';
        }
        return $output;
    }

    public function setup($id) {
        $workout = Workout::findOrFail($id);
        return $workout->days_as_html;
    }
}
