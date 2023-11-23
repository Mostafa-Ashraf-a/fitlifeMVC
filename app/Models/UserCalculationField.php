<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCalculationField extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
      'macronutrients_amount_answer','protein_intake','carbs_intake','fats_intake',
      'body_fat_percentage_answer','waist_circumference','neck_circumference','hip_circumference',
      'weight_before_training','weight_after_training'
    ];
}
