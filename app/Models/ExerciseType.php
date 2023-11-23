<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class ExerciseType extends Model implements TranslatableContract
{
    use HasFactory, Translatable;
    public $translatedAttributes = ['value'];
    protected $fillable = ['type'];

    public function muscles()
    {
        $now = Carbon::now('Asia/Riyadh')->format('Y-m-d');
        return $this->belongsToMany(BodyPart::class, 'user_exercise_program_suggestions', 'exercise_type_id','body_part_id')
            ->where('user_id',auth()->guard('user-api')->user()->id)
//            ->groupBy('day_id','exercise_type_id')
            ->whereDate('start_at','<=',$now)
            ->whereDate('end_at','>=',$now)
            ->where('program_duration',1)
            ->distinct();
    }
    public function weeklyPlanMuscles()
    {
        return $this->belongsToMany(BodyPart::class, 'user_exercise_program_suggestions', 'exercise_type_id','body_part_id')
            ->where('user_id',auth()->guard('user-api')->user()->id)
//            ->groupBy('day_id','exercise_type_id')
            ->whereDate('start_at','=',\request()->query('start_at'))
            ->whereDate('end_at','=',\request()->query('end_at'))
            ->where('program_duration',2)
            ->distinct();
    }
}
