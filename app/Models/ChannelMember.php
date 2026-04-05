<?php

namespace App\Models;

use App\Models\Channel;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'workspace_id', 'channel_id'])]
class ChannelMember extends Model
{
    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function workspace()
    {
        $this->belongsTo(Workspace::class);
    }

    public function channel()
    {
        $this->belongsTo(Channel::class);
    }
}