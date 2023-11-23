<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Answer extends Model implements TranslatableContract
{
    use HasFactory, Translatable;
    public $translatedAttributes = ['answer_content'];
    protected $fillable = ['question_id'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
