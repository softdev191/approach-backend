<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RefreshToken extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'token',
        'expiration',
        'user_uuid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function scopeActive(Builder $query)
    {
        return $query->where("expiration", ">", Carbon::now());
    }

}
