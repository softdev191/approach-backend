<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockedUsers extends Model
{
    protected $fillable = [
        'blocked_user_uuid',
        'blocked_by'
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];
}
