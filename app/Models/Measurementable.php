<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measurementable extends Model
{
    use HasFactory;
    protected $table = 'measurementables';
    protected $fillable = ['measurementable_type','measurementable_id','quantity','measurement_unit_id'];
    public function measurementables()
    {
        return $this->morphTo();
    }
}
