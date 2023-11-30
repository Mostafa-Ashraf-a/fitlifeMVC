<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanQuantity extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'user_id',
        'recipe_id',
        'food_exchange_id',
        'food_type_id',
        'measurement_unit_id',
        'quantity',
    ];
}
