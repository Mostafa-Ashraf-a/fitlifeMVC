<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallengeTranslation extends Model
{
    use HasFactory;
    protected $fillable = ['title','description'];
    public $timestamps = false;
}
