<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GenderMeta extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'uuid',
        'value'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
