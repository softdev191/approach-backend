<?php

namespace App\Models;

use App\AbstractBases\AbstractBaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Message extends AbstractBaseModel
{

    /**
     * @var array
     */
    protected $fillable = [
        'uuid',
        'sender',
        'receiver',
        'content',
        'attachment',
        'seen',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function setAttachmentAttribute($value)
    {
        $image = base64_decode($value);

        $filename = Carbon::now()->timestamp . mt_rand(100,999).".". getBase64FileType($image);
        Storage::disk('s3_message_attachment')->put( $filename, $image );
        $this->attributes['attachment'] = $filename;
    }


    public function getAttachmentAttribute($value)
    {
        return ( $value )? Storage::disk('s3_message_attachment')->url($value) : null;
    }
}
