<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Nudge extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'from_user_uuid',
        'to_user_uuid',
        'type',
        'location',
        'isActive',
        'status',
        'lat',
        'lng'
    ];

    protected $appends = [
        'minute_from_request',
        'time_remaining'
    ];
    /**
     * @var array
     */
    protected $hidden = [
        'id',
      //  'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i:s'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'from_user_uuid', 'uuid');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_uuid', 'uuid');
    }


    public function getMinuteFromRequestAttribute()
    {
        $date = ($this->status == 'accepted') ? $this->updated_at : $this->created_at;
        $diff = $date->diffInMinutes(Carbon::now());
        return $diff;
    }

    public function getTimeRemainingAttribute()
    {
        $date = ($this->status == 'accepted') ? $this->updated_at : $this->created_at;
        $diff = $date->diffInMinutes(Carbon::now());
        $remaining = 20 -intval($diff);

        if($remaining < 0){
            return 0;
        }
        return $remaining;
    }
}
