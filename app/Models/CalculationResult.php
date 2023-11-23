<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalculationResult extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'daily_calories_goal',
        'min_daily_calories',
        'max_daily_calories',
        'body_mass_index',
        'body_mass_index_text',

        'protein_calories',
        'carbs_calories',
        'fats_calories',

        'protein_grams',
        'carbs_grams',
        'fats_grams',

        'approximated_body_fat_percentage_based_on_bmi',

        'new_macronutrients_in_calories_protein',
        'new_macronutrients_in_calories_carbs',
        'new_macronutrients_in_calories_fats',

        'new_macronutrients_in_grams_protein',
        'new_macronutrients_in_grams_carbs',
        'new_macronutrients_in_grams_fats',

        'body_fat_percentage_yes',
        'fat_mass_yes',
        'lean_mass_yes',

        'body_fat_percentage_no',
        'fat_mass_no',
        'lean_mass_no',

        'water_intake_after_exercise',


        'starches',
        'fruits',
        'vegetables',
        'meats',
        'dairy',
        'oils',
        'total_calories',
        'total_protein',
        'total_carbs',
        'total_fats',
        'starches_result',
        'fruits_result',
        'vegetables_result',
        'meats_result',
        'dairy_result',
        'oils_result',
    ];
}
