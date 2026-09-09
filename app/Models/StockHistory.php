<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockHistory extends Model
{
    protected $fillable = [
        'product_id',
        'trans_type',
        'qty',
        'refrence',
        'created_at',
        'updated_at'
    ];
}
