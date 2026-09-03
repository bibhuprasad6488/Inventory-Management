<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'img_path',
        'parent_category',
        'status',
        'created_at',
        'updated_at'
    ];

    // protected $hidden = [
    //     'parent_category',
    // ];

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_category');
    }
    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_category');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
