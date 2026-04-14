<?php

namespace App\Models;

use App\Models\Channel;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['message', 'files', 'user_id', 'workspace_id', 'channel_id'])]
class Message extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}