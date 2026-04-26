<?php

namespace App\Models;

use App\Models\ChannelMember;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable(['title', 'description', 'is_deletable', 'is_default', 'type', 'is_private', 'unique_id'])]
class Channel extends Model
{
    public function channel_members()
    {
        return $this->hasMany(ChannelMember::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function getMemberCountLabelAttribute()
    {
        $count = $this->is_private ? $this->channel_members()->count() : User::count();
        return $count . ' ' . Str::plural('member', $count);
    }

    public function isMember($userId): bool
    {
        return $this->channel_members->contains('user_id', $userId);
    }
}