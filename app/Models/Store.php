<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Store extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'address',
        'logo',
        'lat',
        'lng'
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

    public function getLogoAttribute()
    {
        return ($this->attributes['logo']) ? Storage::disk('s3_store_logo')->url($this->attributes['logo']) : null ;
    }
}
