<?php

namespace App\Models;

use App\Models\Channel;
use App\Models\ChannelMember;
use App\Models\Member;
use App\Models\User;
use App\Models\WorkspaceCategory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'unique_id', 'workspace_category_id', 'description', 'logo', 'is_active', 'user_id', 'is_deleted', 'is_public'])]
class Workspace extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function channels()
    {
        return $this->hasMany(Channel::class);
    }

    public function public_channels()
    {
        return $this->hasMany(Channel::class)->where('is_private', false);
    }

    public function general_chat()
    {
        return $this->hasOne(Channel::class)->where('title', 'general');
    }

    public function category()
    {
        return $this->belongsTo(WorkspaceCategory::class, 'workspace_category_id', 'id');
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function first_members()
    {
        return $this->hasMany(Member::class)->limit(6);
    }

    public function channel_members()
    {
        return $this->hasMany(ChannelMember::class);
    }
}