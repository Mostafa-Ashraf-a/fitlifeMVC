<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;
    public const WORKOUT_PLACE_TYPE_HOME = 2;
    public const WORKOUT_PLACE_TYPE_GYM = 1;
    protected $fillable = [
      'title','description','goal_id','level_id','image','type_id','place_type'
    ];

    public function goal()
    {
        return $this->belongsTo(Goal::class,'goal_id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class,'level_id');
    }

    public function dayOne()
    {
        return $this->hasMany(DayOne::class);
    }

    public function dayTwo()
    {
        return $this->hasMany(DayTwo::class);
    }
    public function dayThree()
    {
        return $this->hasMany(DayThree::class);
    }
    public function dayFour()
    {
        return $this->hasMany(DayFour::class);
    }
    public function dayFive()
    {
        return $this->hasMany(DayFive::class);
    }
    public function daySix()
    {
        return $this->hasMany(DaySix::class);
    }
    public function daySeven()
    {
        return $this->hasMany(DaySeven::class);
    }

    public function dayExerciseBodyParts()
    {
        return $this->hasMany(DayExerciseBodyPart::class, 'workout_id');
    }

    public function dayExerciseTypes()
    {
        return $this->hasMany(DayExerciseType::class, 'workout_id');
    }

    public function getDaysAsHtmlAttribute()
    {
        $exercise_types = ExerciseType::get();
        $body_parts     = BodyPart::get();

        return [
            $this->daysAsHtmlHandler($this->dayOne, 1, $exercise_types, $body_parts),
            $this->daysAsHtmlHandler($this->dayTwo, 2, $exercise_types, $body_parts),
            $this->daysAsHtmlHandler($this->dayThree, 3, $exercise_types, $body_parts),
            $this->daysAsHtmlHandler($this->dayFour, 4, $exercise_types, $body_parts),
            $this->daysAsHtmlHandler($this->dayFive, 5, $exercise_types, $body_parts),
            $this->daysAsHtmlHandler($this->daySix, 6, $exercise_types, $body_parts),
            $this->daysAsHtmlHandler($this->daySeven, 7, $exercise_types, $body_parts)
        ];
    }

    protected function daysAsHtmlHandler($full_day, $day_number, $exercise_types, $body_parts)
    {
        $html = '';

        foreach($full_day as $key => $day) {
            $exercise_type_day = '';
            $body_part_day = '';
            $day_exercise_body_part = DayExerciseBodyPart::where('workout_id', $this->id)
                                                         ->where('day', $day_number)
                                                         ->offset($key)
                                                         ->first();
            $exercise_day = '';
            $exercises    = Exercise::where('muscle_id', $day_exercise_body_part->body_part_id)
                                    ->where('exercise_category', $day->exercise_type)
                                    ->get();
            $count = $key + 1;

            foreach($exercise_types as $exercise_type) {
                $is_selected = $day->exercise_type == $exercise_type->type ? 'selected' : '';
                $exercise_type_day .= "<option value='$exercise_type->type' $is_selected>$exercise_type->value</option>";
            }

            foreach($body_parts as $body_part) {
                $is_selected = $day_exercise_body_part->body_part_id == $body_part->id ? 'selected' : '';
                $body_part_day .= "<option value='$body_part->id' $is_selected>$body_part->title</option>";
            }

            foreach($exercises as $exercise) {
                $is_selected = $day->exercise_id == $exercise->id ? 'selected' : '';
                $exercise_day .= "<option value='$exercise->id' $is_selected>$exercise->title</option>";
            }

            $html .= "
            <tr>
                <td>
                    <select name='exercise_type_day_{$day_number}[]' class='form-control exercise_type_day_$day_number'>
                        $exercise_type_day
                    </select>
                </td>
                <td>
                    <select name='body_part_day_{$day_number}[]' class='form-control body_part_day_$day_number' data-body_part_day_$day_number='$count' required=''>
                        <option value=''>Select Body Part</option>
                        $body_part_day
                    </select>
                </td>
                <td>
                    <select name='exercise_day_{$day_number}[]' class='form-control exercise_day_$day_number' id='exercise_day_{$day_number}{$count}'>
                        <option selected='' disabled=''>Select Exercise</option>
                        $exercise_day
                    </select>
                </td>
                <td>
                    <button type='button' name='remove' class='btn btn-danger btn-small remove_day_$day_number'>remove <i class='fa fa-minus'></i></button>
                </td>
            </tr>
            ";
        }

        return $html;
    }

    public function deleteDays() {
        $this->dayOne()->delete();
        $this->dayTwo()->delete();
        $this->dayThree()->delete();
        $this->dayFour()->delete();
        $this->dayFive()->delete();
        $this->daySix()->delete();
        $this->daySeven()->delete();
        $this->dayExerciseBodyParts()->delete();
        $this->dayExerciseTypes()->delete();
    }
}
