<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanManagement extends Model implements TranslatableContract
{
    use HasFactory, Translatable;
    public $translatedAttributes = ['plan_name','description','features'];
    protected $fillable = ['plan_duration_id','trail_period','price','is_active','currency','trail_interval'];

    public function planDuration() : BelongsTo
    {
        return $this->belongsTo(PlanDuration::class,'plan_duration_id');
    }
}
