<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
    protected $fillable = [
        'user_id',
        'push_token',
        'platform',
        'device_name',
        'is_active',
        'created_at',
        'updated_at'
    ];
}
