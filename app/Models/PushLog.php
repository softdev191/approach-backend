<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PushLog extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'device_token_id',
        'title',
        'payload'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];
}
