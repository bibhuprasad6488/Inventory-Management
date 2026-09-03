<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackSize extends Model
{
    protected $fillable = [
        'qty',
        'status',
        'created_at',
        'updated_at'
    ];


    public function products()
    {
        return $this->hasMany(Product::class, 'pack_size');
    }
}
