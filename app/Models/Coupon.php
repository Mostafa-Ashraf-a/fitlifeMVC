<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
      'name',
      'code',
      'discount_type',
      'discount_value',
      'start_date',
      'end_date',
      'usage_limit',
      'usage',
      'status',
    ];
}
