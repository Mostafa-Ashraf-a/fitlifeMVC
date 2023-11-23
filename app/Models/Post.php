<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model implements TranslatableContract
{
    use HasFactory, Translatable;
    public $translatedAttributes = ['title','description'];
    protected $fillable = ['tag_id','category_id','featured','status','image','category_type_id'];

    public function tag() : BelongsTo
    {
        return $this->belongsTo(Tag::class,'tag_id');
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class,'category_id');
    }


}
