<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function sub_subcategory()
    {
        return $this->belongsTo(SubSubCategory::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->where('parent_id', 0)->with(['user', 'replies'])->latest();
    }

    public function comment_count()
    {
        return $this->hasMany(Comment::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favourite::class)->with('user');
    }

}
