<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeMealType extends Model
{
    use HasFactory;
    protected $fillable = [
      'recipe_id','meal_type_id'
    ];
}
