<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class MeasurementUnit extends Model implements TranslatableContract
{
    use HasFactory, Translatable;
    public $translatedAttributes = ['name'];
    protected $fillable = [];

    public function foodExchanges()
    {
        return $this->belongsToMany(FoodExchange::class,'food_exchange_measurements');
    }

}
