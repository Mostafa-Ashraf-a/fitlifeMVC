<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanManagementTranslation extends Model
{
    use HasFactory;
    protected $fillable =  ['plan_name','description','features'];
    public $timestamps = false;
}
