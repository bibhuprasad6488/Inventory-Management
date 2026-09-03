<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'product_name',
        'slug',
        'hsn',
        'description',
        'category_id',
        'pack_size',
        'mrp',
        'cost_price',
        'selling_price',
        'status',
        'image',
        'created_at',
        'updated_at'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function packSize()
    {
        return $this->belongsTo(PackSize::class, 'pack_size');
    }
}
