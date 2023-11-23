<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model implements TranslatableContract
{
    use HasFactory, Translatable;
    public $translatedAttributes = ['title','description'];
    protected $fillable = ['image'];
    protected $appends = ['image_url'];
    public function getImageUrlAttribute($value)
    {
        $asset = asset('/');
        return $asset . 'assets/images/challenges/' . $this->image;
    }
    public function exercises()
    {
        return $this->belongsToMany(Exercise::class,'challenge_exercise','challenge_id','exercise_id');
    }
}
