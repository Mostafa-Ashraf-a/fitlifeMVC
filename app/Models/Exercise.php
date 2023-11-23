<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Exercise extends Model implements TranslatableContract
{
    use HasFactory, Translatable;
    public $translatedAttributes = ['title','tips','instructions'];
    protected $fillable = [
      'equipment_id','level_id','muscle_id','image','video','exercise_category','place'
    ];
    public function level(){
        return $this->belongsTo(Level::class,'level_id');
    }
    public function equipment(){
        return $this->belongsTo(Equipment::class,'equipment_id');
    }

    public function bodyParts()
    {
        return $this->belongsToMany(BodyPart::class,'exercise_body_parts');
    }

    public function muscle() : BelongsTo
    {
        return $this->belongsTo(BodyPart::class, 'muscle_id');
    }

    public function scopeExerciseDaySetting($day)
    {
        return ExerciseDaySetting::where('user_id',auth()->guard('user-api')->user()->id)
            ->where('day',$day)
            ->first();
    }
    public function scopeUserExerciseDaySetting($exerciseId,$day)
    {
        return UserExerciseDaySetting::where('user_id',auth()->guard('user-api')->user()->id)
            ->where('exercise_id',$exerciseId)
            ->where('day',$day)
            ->first();
    }
    public function muscleExercisePlan()
    {
        return $this->belongsToMany(BodyPart::class, 'user_day_exercise','user_id','body_part_id')
            ->withPivot(['exercise_id','days']);
    }

    // v2

    public function scopeExerciseDaySettingSets($exerciseId, $day)
    {
        $result = DB::table('user_exercise_day_settings')->where('user_id',auth()->guard('user-api')->user()->id)
            ->where('day',$day)
            ->where('exercise_id',$exerciseId)
            ->select('sets')
            ->first();
        return $result->sets ?? null;
    }
    public function scopeExerciseDaySettingRest($exerciseId, $day)
    {
        $result = DB::table('user_exercise_day_settings')->where('user_id',auth()->guard('user-api')->user()->id)
            ->where('day',$day)
            ->where('exercise_id',$exerciseId)
            ->select('rest')
            ->first();
        return $result->rest ?? null;
    }
    public function scopeExerciseDaySettingReps($exerciseId, $day)
    {
        $result = DB::table('user_exercise_day_settings')->where('user_id',auth()->guard('user-api')->user()->id)
            ->where('day',$day)
            ->where('exercise_id',$exerciseId)
            ->select('reps')
            ->first();
        return $result->reps ?? null;
    }


}
