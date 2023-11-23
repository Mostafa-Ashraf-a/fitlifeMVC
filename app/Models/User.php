<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    const  MASTER_SERVING                 = 1;
    const  USED_SERVING                   = 2;
    const  UNDER_IMPLEMENTATION_SERVING   = 3;
    const IN_PROGRESS_PLAN                = 2;
    const  ARCHIVED                       = 3;
    const UNDER_CONSTRUCTION_PLAN         = 1;

    protected $fillable = [
        'full_name', 'email', 'mobile', 'password','goal','weight','height','level',
        'age', 'gender', 'image', 'user_type', 'otp_code', 'otp_count',
        'is_verified',
        'status',
        'serving_reset_time',
        'starches',
        'fruits',
        'vegetables',
        'meats',
        'dairy',
        'oils',
    ];

    protected $hidden = [
        'password',
        'user_type',
        'otp_count',
        'email_verified_at',
        'otp_code',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class,'user_day_exercise','user_id','exercise_id')
            ->withPivot('days');
    }

    public function exerciseDaySetting()
    {
        return $this->belongsTo(ExerciseDaySetting::class,'user_id');
    }

    public function calculationResult()
    {
        return $this->belongsToMany(Question::class,'user_question_answer','user_id','question_id')
            ->withPivot('answer_id');
    }

    public function mealTypes()
    {
        return $this->belongsToMany(MealType::class,'user_meal_type_food_exchanges','user_id','meal_type_id')
            ->withPivot(['food_exchange_id','date'])
            ->where('date','=',request()->query('date'))
            ->where('user_id',auth()->guard('user-api')->user()->id)
            ->groupBy('meal_type_id','date');
    }

    public function userBodyMassIndex()
    {
        return $this->hasOne(CalculationResult::class,'user_id');
    }

    public function scopeWhereServingResetTime($query)
    {
        return $query->where('serving_reset_time', Carbon::now('Asia/Riyadh')->format('h') . ':00:00');
    }

    public function exercisePlan()
    {
        return $this->belongsToMany(BodyPart::class,'user_day_exercise','user_id','body_part_id')
            ->withPivot('days')
            ->groupBy('body_part_id');
    }

    public function day()
    {
        return $this->belongsToMany(Day::class, 'user_days', 'user_id','day_id')
            ->where('user_id',auth()->guard('user-api')->user()->id)
            ->groupBy('day_id','body_part_id','exercise_id')
            ->distinct();
    }
    // old
//    public function weeklyProgram()
//    {
//        $now = Carbon::now('Asia/Riyadh')->format('Y-m-d');
//        return $this->belongsToMany(Day::class, 'user_exercise_program_suggestions', 'user_id','day_id')
//            ->where('user_id',auth()->guard('user-api')->user()->id)
//            ->groupBy('day_id','user_id')
//            ->where('program_duration',2)
//            ->distinct();
//    }
    public function weeklyProgram()
    {
        $now = Carbon::now('Asia/Riyadh')->format('Y-m-d');
        return $this->belongsToMany(Day::class, 'user_exercise_program_suggestions', 'user_id','day_id')
            ->where('user_id',auth()->guard('user-api')->user()->id)
            ->groupBy('day_id','user_id')
            ->whereDate('start_at','=',\request()->query('start_at'))
            ->whereDate('end_at','=',\request()->query('end_at'))
            ->where('program_duration',2)
            ->distinct();
    }

    public function program()
    {
        $now = Carbon::now('Asia/Riyadh')->format('Y-m-d');
        return $this->belongsToMany(Day::class, 'user_exercise_program_suggestions', 'user_id','day_id')
            ->where('user_id',auth()->guard('user-api')->user()->id)
            ->groupBy('day_id','user_id')
            ->whereDate('start_at','<=',$now)
            ->whereDate('end_at','>=',$now)
            ->where('program_duration',1)
            ->distinct();
    }

    public function scopeHasRunningExerciseProgram() : bool
    {
        $user = auth()->guard('user-api')->user();
        $check = DB::table('user_exercise_suggestion')
            ->where('user_id', $user->id)
            ->first();
        if(isset($check)){
            return true;
        }
        return false;
    }

    public function historyPlan()
    {
        return $this->belongsToMany(MealPlan::class,'user_meals_plans','user_id','plan_id')
            ->where('status',self::ARCHIVED)
            ->where('user_id',auth()->guard('user-api')->user()->id)
            ->groupBy('plan_id');
    }

    public function meals()
    {
        return $this->belongsToMany(Meal::class,'user_meals_plans','user_id','meal_id')
            ->groupBy('meal_id')
            ->where('user_id',auth()->guard('user-api')->user()->id);
    }

    public function masterServing() : HasOne
    {
        return $this->hasOne(Serving::class, 'user_id')
            ->where('user_id', auth()->guard('user-api')->user()->id)
            ->where('status', self::MASTER_SERVING)
            ->where('plan_status', 0);
    }

    public function usedServing() : HasOne
    {
        return $this->hasOne(Serving::class, 'user_id')
            ->where('user_id', auth()->guard('user-api')->user()->id)
            ->where('status', self::USED_SERVING)
            ->whereIn('plan_status', [self::IN_PROGRESS_PLAN,self::UNDER_CONSTRUCTION_PLAN]);
    }

    public function underImplementationServing() : HasOne
    {
        return $this->hasOne(Serving::class, 'user_id')
            ->where('user_id', auth()->guard('user-api')->user()->id)
            ->where('status', self::UNDER_IMPLEMENTATION_SERVING)
            ->where('plan_status', self::IN_PROGRESS_PLAN);
    }

    public function usedHistoryServing() : HasOne
    {
        return $this->hasOne(Serving::class, 'user_id')
            ->where('user_id', auth()->guard('user-api')->user()->id)
            ->where('plan_id', request()->query('history_plan_id'))
            ->where('status', self::USED_SERVING)
            ->where('plan_status', self::ARCHIVED);
    }

    public function underImplementationHistoryServing() : HasOne
    {
        return $this->hasOne(Serving::class, 'user_id')
            ->where('user_id', auth()->guard('user-api')->user()->id)
            ->where('plan_id', request()->query('history_plan_id'))
            ->where('status', self::UNDER_IMPLEMENTATION_SERVING)
            ->where('plan_status', self::ARCHIVED);
    }
}
