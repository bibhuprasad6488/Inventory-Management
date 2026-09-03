<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'amount',
        'user_id',
        'mode_of_payment',
        'order_date',
        'status',
        'created_at',
        'updated_at'
    ];


    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
}
