<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FoodExchange extends Model implements TranslatableContract
{
    use HasFactory, Translatable;
    public $translatedAttributes = ['title'];
    protected $fillable = ['food_type_id','image'];



    public function mUnits()
    {
        return $this->belongsToMany(MeasurementUnit::class,'food_exchange_measurements')
            ->withPivot('quantity');
    }
    public function mealTypes()
    {
        return $this->belongsToMany(MealType::class,'user_meal_type_food_exchanges');
    }

    // V2

    public function foodType() : BelongsTo
    {
        return $this->belongsTo(FoodType::class,'food_type_id');
    }

    public function measurementUnits() : BelongsToMany
    {
        return $this->belongsToMany(MeasurementUnit::class,'food_exchange_measurements')
            ->withPivot('quantity');
    }

}
