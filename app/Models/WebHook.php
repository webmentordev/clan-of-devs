<?php

namespace App\Models;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class WebHook extends Model
{
    protected $fillable = [
        "title",
        "user_id",
        "channel_id",
        "webhook",
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function channel(){
        return $this->belongsTo(Channel::class);
    }
}