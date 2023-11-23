<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeFoodExchange extends Model
{
    use HasFactory;
    protected $fillable = [
      'recipe_id',
      'food_exchange_id',
    ];
}
