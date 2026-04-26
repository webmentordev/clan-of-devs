<?php

namespace App\Models;

use App\Models\ChannelMember;
use App\Models\Message;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'description', 'is_deletable', 'type', 'is_private', 'unique_id'])]
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

    public function isMember($userId): bool
    {
        return $this->channel_members->contains('user_id', $userId);
    }
}