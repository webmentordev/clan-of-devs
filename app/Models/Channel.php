<?php

namespace App\Models;

use App\Models\ChannelMember;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable(['title', 'workspace_id', 'description', 'is_deletable', 'type', 'is_private', 'slug', 'unique_id', 'user_id'])]
class Channel extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }

    public function channel_members()
    {
        return $this->hasMany(ChannelMember::class);
    }

    public function getMemberCountLabelAttribute()
    {
        $count = $this->is_private ? $this->channel_members()->count() : $this->workspace->members()->count();
        return $count . ' ' . Str::plural('member', $count);
    }
}