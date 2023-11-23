<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Day extends Model
{
    use HasFactory;
    protected $fillable = [
        'value',
        'day'
    ];
    public function muscle()
    {
        return $this->belongsToMany(BodyPart::class,'user_days','day_id','body_part_id')
            ->where('user_id',auth()->guard('user-api')->user()->id)
            ->groupBy('day_id','body_part_id')
            ->distinct();
    }

    // v2
    public function scopeExerciseDaySettingSets($day)
    {
        $result = DB::table('exercise_day_settings')->where('user_id',auth()->guard('user-api')->user()->id)
            ->where('day',$day)
            ->select('sets')
            ->first();
        return $result->sets ?? null;
    }
    public function scopeExerciseDaySettingRest($day)
    {
        $result = DB::table('exercise_day_settings')->where('user_id',auth()->guard('user-api')->user()->id)
            ->where('day',$day)
            ->select('rest')
            ->first();
        return $result->rest ?? null;
    }
    public function scopeExerciseDaySettingReps($day)
    {
        $result = DB::table('exercise_day_settings')->where('user_id',auth()->guard('user-api')->user()->id)
            ->where('day',$day)
            ->select('reps')
            ->first();
        return $result->reps ?? null;
    }


    public function exerciseType()
    {
        $now = Carbon::now('Asia/Riyadh')->format('Y-m-d');
        return $this->belongsToMany(ExerciseType::class, 'user_exercise_program_suggestions', 'day_id','exercise_type_id')
            ->where('user_id',auth()->guard('user-api')->user()->id)
            ->groupBy('day_id','exercise_type_id')
            ->whereDate('start_at','<=',$now)
            ->whereDate('end_at','>=',$now)
            ->where('program_duration',1)
            ->distinct();
    }

    public function weeklyExerciseType()
    {
        return $this->belongsToMany(ExerciseType::class, 'user_exercise_program_suggestions', 'day_id','exercise_type_id')
            ->where('user_id',auth()->guard('user-api')->user()->id)
            ->groupBy('day_id','exercise_type_id')
            ->whereDate('start_at','=',\request()->query('start_at'))
            ->whereDate('end_at','=',\request()->query('end_at'))
            ->where('program_duration',2)
            ->distinct();


    }
}
