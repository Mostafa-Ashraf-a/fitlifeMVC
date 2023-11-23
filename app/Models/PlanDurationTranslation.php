<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanDurationTranslation extends Model
{
    use HasFactory;
    protected $fillable = ['duration_name'];
    public $timestamps = false;
}
