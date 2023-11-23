<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class BodyPart extends Model implements TranslatableContract
{
    use HasFactory, Translatable;
    public $translatedAttributes = ['title'];
    protected $fillable = ['image'];
    public function post()
    {
        return $this->belongsTo(Exercise::class);
    }

    public function userExercisePlan()
    {
        return $this->belongsToMany(Exercise::class,'user_day_exercise','body_part_id','exercise_id')
            ->where('user_id', auth()->guard('user-api')->user()->id)
            ->withPivot('days')
            ->groupBy('body_part_id','exercise_id');
    }
    public function exercises()
    {
        return $this->belongsToMany(Exercise::class,'user_days','body_part_id','exercise_id')
            ->where('user_id',auth()->guard('user-api')->user()->id)
            ->groupBy('day_id','exercise_id')
            ->distinct();
    }

    public function exerciseSuggestions()
    {
        $now = Carbon::now('Asia/Riyadh')->format('Y-m-d');
        return $this->belongsToMany(Exercise::class, 'user_exercise_program_suggestions', 'body_part_id','exercise_id')
            ->where('user_id',auth()->guard('user-api')->user()->id)
//            ->groupBy('day_id','exercise_type_id')
            ->whereDate('start_at','<=',$now)
            ->whereDate('end_at','>=',$now)
            ->where('program_duration',1)
            ->distinct();
    }

    public function weeklyExerciseSuggestions()
    {
        return $this->belongsToMany(Exercise::class, 'user_exercise_program_suggestions', 'body_part_id','exercise_id')
            ->where('user_id',auth()->guard('user-api')->user()->id)
//            ->groupBy('day_id','exercise_type_id')
            ->whereDate('start_at','=',\request()->query('start_at'))
            ->whereDate('end_at','=',\request()->query('end_at'))
            ->where('program_duration',2)
            ->distinct();
    }
}
