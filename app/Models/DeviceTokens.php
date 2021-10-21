<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceTokens extends Model
{
    protected $fillable = [
        'user_uuid',
        'device_token',
        'arn',
        'platform'
    ];
}
