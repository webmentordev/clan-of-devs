<?php

use App\Models\Channel;
use App\Models\ChannelMember;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('channel.{channelId}', function ($user, $channelId) {
    $channel = Channel::find($channelId);
    if (! $channel) return false;
    if (! $channel->is_private) return true;
    return ChannelMember::where('user_id', $user->id)->where('channel_id', $channelId)->exists();
});