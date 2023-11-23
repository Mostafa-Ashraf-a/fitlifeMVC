<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingTranslation extends Model
{
    use HasFactory;
    protected $fillable = ['privacy_policy','terms_of_service','about_us'];
    public $timestamps = false;
}
