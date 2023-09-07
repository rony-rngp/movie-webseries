<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sub_subcategories()
    {
        return $this->hasMany(SubSubCategory::class, 'subcategory_id')->where('status', 1);
    }

}
