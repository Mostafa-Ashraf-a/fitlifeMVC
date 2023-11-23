<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealTypeTranslation extends Model
{
    # TODO Delete this table, as there is another table (meals) that performs the same function to save user meals like (BreakFast & Dinner/Lunch & Snack)
    use HasFactory;
    protected $fillable = ['title'];
    public $timestamps = false;
}
