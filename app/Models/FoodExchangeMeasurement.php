<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodExchangeMeasurement extends Model
{
    use HasFactory;
    protected $fillable = ['food_exchange_id','measurement_unit_id','quantity'];
}
